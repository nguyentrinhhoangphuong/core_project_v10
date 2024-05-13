<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Setting extends MainModel
{
    use HasFactory;

    public $folderUpload = 'Setting';

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-item') {
            $query = self::select('id', 'key_value', 'value', 'created_by', 'created_at', 'updated_at', 'updated_by');

            if ($params['filter']['status'] != 'all') {
                $query->where('status', $params['filter']['status']);
            }

            if (!empty($params['search']['value'])) {
                $searchValue = "%{$params['search']['value']}%";
                if ($params['search']['field'] == 'all') {
                    $query->where(function ($query) use ($searchValue) {
                        array_shift($this->fieldSearchAccepted); // bỏ all
                        foreach ($this->fieldSearchAccepted as $field) {
                            $query->orWhere($field, 'LIKE', $searchValue);
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', $searchValue);
                }
            }

            $result = $query->orderBy('id', 'desc')->get();
        }

        if ($options['task'] == 'admin-list-items-in-selectbox') {
            $query = self::select('id', 'name')->where('parent_id', '>', 0)->orderBy('name', 'asc');
            $result = $query->pluck('name', 'id')->toArray();
        }


        return $result;
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'key_value', 'value', 'created_at', 'updated_at')->where('key_value', $params)->first();
        }
        return $result;
    }

    public function getAll()
    {
        $result = self::select('id', 'key_value', 'value', 'created_at', 'updated_at')->get();
        return $result;
    }

    public function saveItem($request, $options)
    {
        if ($options['task'] == 'add-item-general') {
            $keyValue = "general-config";
            // Lấy dòng cấu hình hiện tại nếu tồn tại
            $existingItem = self::where('key_value', $keyValue)->first();

            // Kiểm tra xem có file hình ảnh mới được gửi trong yêu cầu không
            if (isset($request['logo'])) {
                // Nếu có, lưu hình ảnh logo vào thư mục được chỉ định và lấy đường dẫn
                $logo = $request['logo'];
                $logoPath = $logo->path();
            } else {
                // Nếu không có file hình ảnh mới được gửi, sử dụng đường dẫn logo hiện tại (nếu có)
                $logoPath = isset($existingItem) ? json_decode($existingItem->value, true)['logo'] : null;
            }

            // Tạo một mảng chứa tất cả các thông tin, bao gồm cả đường dẫn logo
            $data = [
                'logo' => $logoPath, // Đường dẫn của logo
                'hotline' => $request['hotline'],
                'address' => $request['address'],
                'email' => $request['email'],
                'email-support' => $request['email-support'],
                'introduce' => $request['introduce'],
                'copyright' => $request['copyright'],
            ];

            // Chuyển mảng thành định dạng JSON
            $jsonValue = json_encode($data);

            if ($existingItem) {
                // Nếu đã tồn tại dòng cấu hình, cập nhật dữ liệu mới
                $existingItem->update([
                    'value' => $jsonValue
                ]);

                // Nếu có file hình ảnh mới được gửi, thay đổi hình ảnh trong Media Library
                if (isset($request['logo'])) {
                    $existingItem->clearMediaCollection($this->folderUpload);
                    $existingItem->addMedia($logo)->toMediaCollection($this->folderUpload);
                }
            } else {
                $item = self::create([
                    'key_value' => $keyValue,
                    'value' => $jsonValue
                ]);
                $item->addMedia($logo)->toMediaCollection($this->folderUpload);
            }
        }

        if ($options['task'] == 'add-item-social') {
            $keyValue = "social-config";
            $existingItem = self::where('key_value', $keyValue)->first();
            $request['id'] = uniqid();
            $newItem = $this->prepareParams($request);
            if ($existingItem) {
                // Lấy ds hiện tại
                $existingItems = json_decode($existingItem->value, true);
                // Thêm mục mới vào ds hiện tại
                $existingItems[] = $newItem;
                $jsonValue = json_encode($existingItems);
                $existingItem->update([
                    'value' => $jsonValue
                ]);
            } else {
                $jsonValue = json_encode([$newItem]);
                $item = self::create([
                    'key_value' => $keyValue,
                    'value' => $jsonValue
                ]);
            }
        }

        if ($options['task'] == 'add-item-help-center') {
            $keyValue = "help-center-config";
            $existingItem = self::where('key_value', $keyValue)->first();
            $request['id'] = uniqid();
            $newItem = $this->prepareParams($request);
            if ($existingItem) {
                // Lấy ds hiện tại
                $existingItems = json_decode($existingItem->value, true);
                // Thêm mục mới vào ds hiện tại
                $existingItems[] = $newItem;
                $jsonValue = json_encode($existingItems);
                $existingItem->update([
                    'value' => $jsonValue
                ]);
            } else {
                $jsonValue = json_encode([$newItem]);
                $item = self::create([
                    'key_value' => $keyValue,
                    'value' => $jsonValue
                ]);
            }
        }

        if ($options['task'] == 'update-social-config') {
            // Trích xuất dữ liệu JSON từ cơ sở dữ liệu
            $existingItem = self::where('key_value', $request['key_value'])->first();
            $items = json_decode($existingItem['value'], true);

            // Lặp qua các mục trong mảng và cập nhật mục tương ứng
            foreach ($items as &$item) {
                if ($item['id'] == $request['id']) {
                    // Cập nhật các giá trị mới từ $request
                    $item['icon'] = $request['icon'];
                    $item['link'] = $request['link'];
                    $item['ordering'] = $request['ordering'];
                    break;
                }
            }
            // Encode lại mảng thành JSON
            $jsonValue = json_encode($items);
            // Lưu lại mảng JSON đã cập nhật vào cơ sở dữ liệu
            $existingItem->value = $jsonValue;
            $existingItem->save();
        }

        if ($options['task'] == 'add-item-useful-links') {
            $keyValue = "useful-links-config";
            $existingItem = self::where('key_value', $keyValue)->first();
            $request['id'] = uniqid();
            $newItem = $this->prepareParams($request);
            if ($existingItem) {
                // Lấy ds hiện tại
                $existingItems = json_decode($existingItem->value, true);
                // Thêm mục mới vào ds hiện tại
                $existingItems[] = $newItem;
                $jsonValue = json_encode($existingItems);
                $existingItem->update([
                    'value' => $jsonValue
                ]);
            } else {
                $jsonValue = json_encode([$newItem]);
                $item = self::create([
                    'key_value' => $keyValue,
                    'value' => $jsonValue
                ]);
            }
        }

        if ($options['task'] == 'update-useful-links-config') {
            // Trích xuất dữ liệu JSON từ cơ sở dữ liệu
            $existingItem = self::where('key_value', $request['key_value'])->first();
            $items = json_decode($existingItem['value'], true);

            // Lặp qua các mục trong mảng và cập nhật mục tương ứng
            foreach ($items as &$item) {
                if ($item['id'] == $request['id']) {
                    // Cập nhật các giá trị mới từ $request
                    $item['name'] = $request['name'];
                    $item['url'] = $request['url'];
                    break;
                }
            }
            // Encode lại mảng thành JSON
            $jsonValue = json_encode($items);
            // Lưu lại mảng JSON đã cập nhật vào cơ sở dữ liệu
            $existingItem->value = $jsonValue;
            $existingItem->save();
        }

        if ($options['task'] == 'update-help-center-config') {
            // Trích xuất dữ liệu JSON từ cơ sở dữ liệu
            $existingItem = self::where('key_value', $request['key_value'])->first();
            $items = json_decode($existingItem['value'], true);

            // Lặp qua các mục trong mảng và cập nhật mục tương ứng
            foreach ($items as &$item) {
                if ($item['id'] == $request['id']) {
                    // Cập nhật các giá trị mới từ $request
                    $item['name'] = $request['name'];
                    $item['url'] = $request['url'];
                    break;
                }
            }
            // Encode lại mảng thành JSON
            $jsonValue = json_encode($items);
            // Lưu lại mảng JSON đã cập nhật vào cơ sở dữ liệu
            $existingItem->value = $jsonValue;
            $existingItem->save();
        }
    }
}
