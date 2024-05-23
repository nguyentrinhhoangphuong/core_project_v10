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
        // =================================== useful links ===================================
        if ($options['task'] == 'add-item-useful-links') {
            echo '<pre style="color:red">';
            print_r("ok");
            echo '</pre>';
            die;
            $keyValue = "useful-links";
            // $existingItem = self::where('key_value', $keyValue)->first();
            $existingItem = $this->isexistsKeyValue($keyValue);
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
                echo '<pre style="color:red">';
                print_r("có vào");
                echo '</pre>';
                die;
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

        // =====================================================================
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

        // =============================== social ================================
        if ($options['task'] == 'add-item-social') {
            if (self::count() > 0) {
                $keyValue = "social";
                $icon = $request->icon;
                $isexistsIcon = $this->isexistsIcon($icon, $keyValue);
                $isexistsKeyValue = $this->isexistsKeyValue($keyValue);
                $request['id'] = uniqid();
                $newItem = $this->prepareParams($request->all());
                $obj = self::where('key_value', $keyValue)->first();
                if ($isexistsIcon) {
                    $newItem['links'] = $this->removeExistLink($obj, $newItem);
                    $values = json_decode($obj->value, true);
                    foreach ($values as &$value) {
                        if ($value['icon'] == $request->icon) {
                            $links = json_decode($value['links'], true);
                            $newValue = json_decode($newItem['links'], true);
                            $newArr = array_merge($links, $newValue);
                            $value['links'] = json_encode($newArr);
                        }
                    }
                    $obj->value = json_encode($values);
                    $obj->save();
                } else if ($isexistsKeyValue && !$isexistsIcon) {
                    $json_array = json_decode($obj->value, true);
                    $json_array[] = $newItem;
                    $new_json = json_encode($json_array, JSON_UNESCAPED_UNICODE);
                    $obj->value = $new_json;
                    $obj->save();
                }
            } else {
                $key_value = 'social';
                $arrayValue = [['icon' => $request->icon, 'links' => $request->links, 'id' => uniqid()]];
                $value = json_encode($arrayValue);
                self::create([
                    'key_value' => $key_value,
                    'value' => $value,
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

        if ($options['task'] == 'ajax-update-social-config') {
            $getItems = $options['getItems'];
            $items = json_decode($getItems['value'], true);
            foreach ($items as &$item) {
                if ($item['id'] == $request->id) {
                    $links  = json_decode($item['links'], true);
                    foreach ($links as &$link) {
                        if ($link['value'] == $request->oldValue) {
                            $link['value'] = $request->newValue;
                        }
                    }
                    // json_encode lại links
                    $item['links'] = json_encode($links);
                }
            }
            // Mã hóa lại JSON
            $newValue = json_encode($items, JSON_UNESCAPED_UNICODE);
            $getItems->update(['value' => $newValue]);
        }

        if ($options['task'] == 'ajax-update-social-positions') {
            $getItems = $options['getItems'];
            $items = json_decode($getItems['value'], true);
            foreach ($items as &$item) {
                if ($item['id'] == $request->id) {
                    $links = [];
                    foreach ($request->tags as $tag) {
                        $links[] = ['value' => $tag];
                    }
                    $item['links'] = json_encode($links);
                }
            }
            $getItems->update(['value' => $items]);
        }

        if ($options['task'] == 'ajax-delete-social-config') {
            $getItems = $options['getItems'];
            $items = json_decode($getItems['value'], true);
            foreach ($items as &$item) {
                if ($item['id'] == $request->id) {
                    $links = json_decode($item['links'], true);
                    foreach ($links as $key => $link) {
                        if ($link['value'] == $request->removedValue) {
                            unset($links[$key]);
                        }
                    }
                    $item['links'] = json_encode(array_values($links));
                }
            }
            $newValue = json_encode($items, JSON_UNESCAPED_UNICODE);
            $getItems->update(['value' => $newValue]);
        }

        if ($options['task'] == 'ajax-insert-social-config') {
            $getItems = $options['getItems'];
            $items = json_decode($getItems['value'], true);
            foreach ($items as &$item) {
                if ($item['id'] == $request->id) {
                    $links = json_decode($item['links'], true);
                    $links[] = ['value' => $request->newValue];
                    $item['links'] = json_encode($links);
                }
            }
            $getItems->update(['value' => $items]);
        }

        if ($options['task'] == 'ajax-update-ordering-social-config') {
            $getItems = $options['getItems'];
            $items = json_decode($getItems['value'], true);

            $positionMap = [];
            foreach ($request->order as $data) {
                $positionMap[$data['id']] = $data['position'];
            }

            // Sắp xếp mảng $items dựa trên vị trí từ $positionMap
            usort($items, function ($a, $b) use ($positionMap) {
                return $positionMap[$a['id']] - $positionMap[$b['id']];
            });
            $newPosition = json_encode($items);
            $getItems->update(['value' => $newPosition]);
        }

        if ($options['task'] == 'ajax-delete-item') {
            $getItems = $options['getItems'];
            $items = json_decode($getItems['value'], true);
            foreach ($items as $key => $item) {
                if ($item['id'] == $request->id) {
                    unset($items[$key]);
                    break; // Exiting the loop once the item is found and removed
                }
            }
            // Reindexing the array after removing an element
            $items = array_values($items);
            // Saving the updated items
            $getItems->value = json_encode($items, JSON_UNESCAPED_UNICODE);
            $getItems->save();
        }
    }

    public function isexistsKeyValue($keyValue)
    {
        return self::where('key_value', $keyValue)->exists();
    }

    public function isexistsIcon($icon, $keyValue)
    {
        $itemsByKeyValue = self::where('key_value', $keyValue)->first();
        $keyValue = json_decode($itemsByKeyValue->value, true);
        foreach ($keyValue as $value) {
            if ($value['icon'] == $icon) {
                return true;
            }
        }
        return false;
    }

    /*
    không làm cách này
    public function removeExistLink($obj, $newItem)
    {
        $result = '';
        $values = json_decode($obj->value, true);
        $arrNewLinks = json_decode($newItem['links'], true);

        foreach ($values as $item) {
            if ($item['icon'] == $newItem['icon']) {
                $arrOldLinks = json_decode($item['links'], true);
                foreach ($arrNewLinks as $newKey => $newLink) {
                    // Lặp qua các phần tử trong $arrOldLinks để kiểm tra sự tồn tại
                    foreach ($arrOldLinks as $oldLink) {
                        if ($newLink['value'] == $oldLink['value']) {
                            // Xóa phần tử khỏi $arrNewLinks nếu tồn tại trong $arrOldLinks
                            unset($arrNewLinks[$newKey]);
                        }
                    }
                }
                $result = json_encode(array_values($arrNewLinks));
            }
        }
        return $result;
    }
   */

    public function removeExistLink($obj, $newItem)
    {
        $values = json_decode($obj->value, true);
        $newLinks = json_decode($newItem['links'], true);
        $result = '';

        foreach ($values as $item) {
            if ($item['icon'] == $newItem['icon']) {
                $oldLinks = json_decode($item['links'], true);
                $oldLinksMap = array_column($oldLinks, 'value');

                $filteredLinks = array_filter($newLinks, function ($newLink) use ($oldLinksMap) {
                    return !in_array($newLink['value'], $oldLinksMap);
                });

                $result = json_encode(array_values($filteredLinks));
                break;
            }
        }

        return $result;
    }
}
