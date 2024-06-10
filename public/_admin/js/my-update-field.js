class EditableField {
    constructor(selector) {
        this.fields = document.querySelectorAll(selector);
        this.attachGlobalClickHandler();
        this.attachFieldHandlers();
    }

    attachGlobalClickHandler() {
        document.addEventListener("click", (event) => {
            if (!event.target.closest(".editable-field")) {
                this.blurAllFields();
            }
        });
    }

    blurAllFields() {
        this.fields.forEach((field) => field.blur());
    }

    attachFieldHandlers() {
        this.fields.forEach((field) => {
            field.dataset.oldValue = field.value;
            field.addEventListener("keypress", (event) =>
                this.handleKeyPress(event, field)
            );
        });
    }

    handleKeyPress(event, field) {
        if (event.which === 13) {
            // Enter key
            event.preventDefault();

            const newValue = field.value;
            const oldValue = field.dataset.oldValue;
            const row = field.closest("tr");
            const itemId = row.dataset.id;
            const routeName = row.dataset.routename;
            const fieldName = field.name;

            if (oldValue !== newValue) {
                this.updateField(itemId, routeName, fieldName, newValue, field);
            }
        }
    }

    updateField(itemId, routeName, fieldName, value, field) {
        fetch(`${routeName}/update-field`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ itemId, fieldName, value }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                fireNotif("Update thành công", "success", 3000);
                field.dataset.oldValue = value;
            })
            .catch((error) => {
                console.error(error);
                fireNotif("Lỗi khi cập nhật", "error", 3000);
            })
            .finally(() => {
                field.blur();
            });
    }
}

// Khởi tạo lớp với selector .editable-field
document.addEventListener("DOMContentLoaded", () => {
    new EditableField(".editable-field");
});
