<!DOCTYPE html>

<html>

<head>

    <title>Create Competition</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>

        body { font-family: Arial, sans-serif; margin: 20px; }

        .form-group { margin-bottom: 15px; }

        label { display: block; margin-bottom: 5px; font-weight: bold; }

        input, textarea, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }

        button { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }

        button:hover { background-color: #0056b3; }

        .alert { margin-top: 20px; padding: 10px; border-radius: 4px; }

        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    </style>

</head>

<body>

    <h1>Create Competition</h1>



    <div id="messages"></div>



    <form id="competitionForm">

        @csrf



        <div class="form-group">

            <label for="title_ar">Title (Arabic):</label>

            <input type="text" name="title_ar" id="title_ar" value="مسابقة الفنون الرقمية الكبرى" required>

        </div>



        <div class="form-group">

            <label for="title_en">Title (English):</label>

            <input type="text" name="title_en" id="title_en" value="The Grand Digital Arts Competition" required>

        </div>



        <div class="form-group">

            <label for="description_ar">Description (Arabic):</label>

            <textarea name="description_ar" id="description_ar" rows="4" required>هذه المسابقة مفتوحة لجميع الطلاب الموهوبين في مجالات التصميم والبرمجة. آخر موعد لتقديم الأعمال هو 10 ديسمبر.</textarea>

        </div>



        <div class="form-group">

            <label for="description_en">Description (English):</label>

            <textarea name="description_en" id="description_en" rows="4" required>This competition is open to all talented students in design and programming fields. The final submission deadline is December 10th.</textarea>

        </div>



        <div class="form-group">

            <label for="start_date">Start Date:</label>

            <input type="date" name="start_date" id="start_date" value="2025-02-11" required>

        </div>



        <div class="form-group">

            <label for="end_date">End Date:</label>

            <input type="date" name="end_date" id="end_date" value="2025-12-25" required>

        </div>



        <div class="form-group">

            <label for="registration_deadline">Registration Deadline:</label>

            <input type="date" name="registration_deadline" id="registration_deadline" value="2025-12-10" required>

        </div>



        <div class="form-group">

            <label for="status">Status:</label>

            <select name="status" id="status" required>

                <option value="draft">Draft</option>

                <option value="active" selected>Active</option>

                <option value="closed">Closed</option>

            </select>

        </div>



        <div class="form-group">

            <label for="max_participants">Max Submissions Per Student:</label>

            <input type="number" name="max_participants" id="max_participants" value="3" min="1" required>

        </div>



        <div class="form-group">

            <label for="allowed_talents">Allowed Talents (select multiple):</label>

            <select multiple name="allowed_talents[]" id="allowed_talents" size="10" required>

                <option value="1" selected>Drawing and Visual Arts</option>

                <option value="2" selected>Photography</option>

                <option value="3" selected>Graphic Design</option>

                <option value="4" selected>Music and Singing</option>

                <option value="5" selected>Public Speaking</option>

                <option value="6" selected>Video Editing and Production</option>

                <option value="7" selected>Programming and Development</option>

                <option value="8" selected>Innovation and Invention</option>

                <option value="9" selected>Entrepreneurship</option>

                <option value="10" selected>Writing and Literature</option>

            </select>

        </div>



        <button type="submit">Create Competition</button>

    </form>



    <script>

        $(document).ready(function() {

            $('#competitionForm').on('submit', function(e) {

                e.preventDefault();



                let formData = new FormData(this);



                $.ajax({

                    url: "{{ route('admin.competitions.store') }}",

                    type: 'POST',

                    data: formData,

                    processData: false,

                    contentType: false,

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    },

                    success: function(response) {

                        $('#messages').html('<div class="alert alert-success">Competition created successfully!</div>');

                        console.log('Success:', response);

                        $('#competitionForm')[0].reset();

                    },

                    error: function(xhr) {

                        let errors = xhr.responseJSON?.errors;

                        let message = '<div class="alert alert-error">';



                        if (errors) {

                            for (let key in errors) {

                                message += `<p>${errors[key].join(', ')}</p>`;

                            }

                        } else {

                            message += `<p>${xhr.responseText}</p>`;

                        }



                        message += '</div>';

                        $('#messages').html(message);

                        console.error('Error:', xhr);

                    }

                });

            });

        });

    </script>

</body>

</html>

