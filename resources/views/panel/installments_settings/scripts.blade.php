
<script>
        let lessons = [];

        var itemId = "{{ $item->id }}";

        $.get('/admin/courses/edit/installments-settings/lessons/' + itemId, function(data) {
            lessons = data;
        });


        var countInsts = 0;

        if(countInsts == 0)
        {
            $('.submitBtn').attr('disabled',true);
        }else{
            $('.submitBtn').attr('disabled',false);
        }

        function addRow() {
          
            const row = `
                <tr>
                    <td><input type="text" name="installment_name[]" required class="form-control"></td>
                    <td><input type="number" name="price[]" step="any" min="1" required class="form-control">
                    </td>
                    <td>
                        <select required name="lesson_id[]" class="form-control">
                            ${lessons.map(lesson => `<option value="${lesson.id}">${lesson.title}</option>`).join('')}
                        </select>
                    </td>
                    <td><button type="button" class="delete-row-btn">حذف</button></td>
                </tr>
            `;
            $('#installments-table tbody').append(row);
            countInsts ++;
        }

        $(document).on('change keyup','.form-control',function(){
            $('.submitBtn').attr('disabled',false);
        });

        $(document).ready(function() {
            // addRow();

            // Add new row on button click
            $('#add-row-btn').click(function() {
                addRow();
                $('.submitBtn').attr('disabled',false);
            });

            // Delete row
            $(document).on('click', '.delete-row-btn', function() {
                $(this).closest('tr').remove();
                countInsts --;
                if(countInsts == 0)
                {
                    $('.submitBtn').attr('disabled',true);
                }else{
                    $('.submitBtn').attr('disabled',false);
                }
            });

            // Handle form submission
            $('#installments-form').submit(function(e) {
                e.preventDefault();

                const installments = [];

                $('#installments-table tbody tr').each(function() {
                    const installmentName = $(this).find('input[name="installment_name[]"]').val();
                    const price = $(this).find('input[name="price[]"]').val();
                    const lessonId = $(this).find('select[name="lesson_id[]"]').val();

                    installments.push({
                        name: installmentName,
                        price: price,
                        lesson_id: lessonId
                    });
                });

                $.ajax({
                    url: '/admin/courses/edit/installments-settings/store',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        installments: installments,
                        course_id:itemId
                    },
                    success: function(response) {
                        customSweetAlert(
                        response.status,
                        response.message,
                        );
                    },
                    error: function(response) {
                        customSweetAlert(
                        response.status,
                        response.message,
                        );
                    }
                });
            });
        });
    </script>
    