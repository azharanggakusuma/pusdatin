<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complex Form Builder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
    <style>
        body {
            margin-top: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .form-actions {
            margin-top: 20px;
        }
        .form-group .remove-btn {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Complex Form Builder</h2>
        <form id="dynamicForm" action="submit_form.php" method="POST">
            <div id="formFields">
                <!-- Fields will be dynamically added here -->
            </div>
            <div class="form-actions text-right">
                <button type="button" class="btn btn-primary" id="addField">Add Field</button>
                <button type="submit" class="btn btn-success">Submit Form</button>
            </div>
        </form>
    </div>

    <!-- Modal for Adding Field -->
    <div class="modal fade" id="fieldModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Add New Field</h4>
                </div>
                <div class="modal-body">
                    <form id="fieldForm">
                        <div class="form-group">
                            <label for="fieldLabel">Field Label</label>
                            <input type="text" class="form-control" id="fieldLabel" placeholder="Enter label (e.g., Name)">
                        </div>
                        <div class="form-group">
                            <label for="fieldType">Field Type</label>
                            <select class="form-control" id="fieldType">
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="email">Email</option>
                                <option value="password">Password</option>
                                <option value="date">Date</option>
                                <option value="textarea">Textarea</option>
                                <option value="select">Dropdown</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="radio">Radio Button</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fieldPlaceholder">Placeholder (optional)</label>
                            <input type="text" class="form-control" id="fieldPlaceholder" placeholder="e.g., Enter your name">
                        </div>
                        <div class="form-group">
                            <label for="fieldRequired">Is Required?</label>
                            <select class="form-control" id="fieldRequired">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                        <div class="form-group" id="fieldOptionsGroup" style="display: none;">
                            <label for="fieldOptions">Options (comma-separated)</label>
                            <input type="text" class="form-control" id="fieldOptions" placeholder="e.g., Option1, Option2">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveField">Add Field</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let fieldIndex = 0;

        // Show or hide options field for select, checkbox, and radio types
        $('#fieldType').on('change', function () {
            const type = $(this).val();
            if (type === 'select' || type === 'checkbox' || type === 'radio') {
                $('#fieldOptionsGroup').show();
            } else {
                $('#fieldOptionsGroup').hide();
            }
        });

        // Add field to the form
        $('#saveField').on('click', function () {
            const label = $('#fieldLabel').val();
            const type = $('#fieldType').val();
            const placeholder = $('#fieldPlaceholder').val();
            const isRequired = $('#fieldRequired').val() === 'yes' ? 'required' : '';
            const options = $('#fieldOptions').val();
            let fieldHTML = '';

            if (type === 'select' && options) {
                const optionHTML = options.split(',').map(opt => `<option value="${opt.trim()}">${opt.trim()}</option>`).join('');
                fieldHTML = `
                    <div class="form-group" id="field-${fieldIndex}">
                        <label>${label}</label>
                        <select class="form-control" name="fields[${fieldIndex}][value]" ${isRequired}>
                            ${optionHTML}
                        </select>
                        <input type="hidden" name="fields[${fieldIndex}][type]" value="${type}">
                        <input type="hidden" name="fields[${fieldIndex}][label]" value="${label}">
                        <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removeField(${fieldIndex})">Remove</button>
                    </div>`;
            } else if ((type === 'checkbox' || type === 'radio') && options) {
                const optionHTML = options.split(',').map(opt => `
                    <label class="${type}-inline">
                        <input type="${type}" name="fields[${fieldIndex}][value]" value="${opt.trim()}" ${isRequired}> ${opt.trim()}
                    </label>`).join('');
                fieldHTML = `
                    <div class="form-group" id="field-${fieldIndex}">
                        <label>${label}</label>
                        ${optionHTML}
                        <input type="hidden" name="fields[${fieldIndex}][type]" value="${type}">
                        <input type="hidden" name="fields[${fieldIndex}][label]" value="${label}">
                        <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removeField(${fieldIndex})">Remove</button>
                    </div>`;
            } else {
                fieldHTML = `
                    <div class="form-group" id="field-${fieldIndex}">
                        <label>${label}</label>
                        <input type="${type}" class="form-control" name="fields[${fieldIndex}][value]" placeholder="${placeholder}" ${isRequired}>
                        <input type="hidden" name="fields[${fieldIndex}][type]" value="${type}">
                        <input type="hidden" name="fields[${fieldIndex}][label]" value="${label}">
                        <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removeField(${fieldIndex})">Remove</button>
                    </div>`;
            }

            $('#formFields').append(fieldHTML);
            $('#fieldModal').modal('hide');
            $('#fieldForm')[0].reset();
            $('#fieldOptionsGroup').hide();
            fieldIndex++;
        });

        // Open modal to add field
        $('#addField').on('click', function () {
            $('#fieldModal').modal('show');
        });

        // Remove field
        function removeField(index) {
            $(`#field-${index}`).remove();
        }
    </script>
</body>
</html>
