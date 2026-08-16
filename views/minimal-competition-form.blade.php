<!DOCTYPE html>
<html>
<head>
    <title>Minimal Competition Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Minimal Competition Form</h1>
    
    <form action="{{ route('admin.competitions.store') }}" method="POST">
        @csrf
        
        <div>
            <label for="title_ar">Title (Arabic):</label>
            <input type="text" name="title_ar" id="title_ar" value="اختبار تصحيح المشكلة" required>
        </div>
        
        <div>
            <label for="title_en">Title (English):</label>
            <input type="text" name="title_en" id="title_en" value="Debug Test Competition" required>
        </div>
        
        <div>
            <label for="description_ar">Description (Arabic):</label>
            <textarea name="description_ar" id="description_ar" required>وصف اختبار تصحيح المشكلة</textarea>
        </div>
        
        <div>
            <label for="description_en">Description (English):</label>
            <textarea name="description_en" id="description_en" required>Debug test competition description</textarea>
        </div>
        
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" value="2025-11-01" required>
        </div>
        
        <div>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" value="2025-12-01" required>
        </div>
        
        <div>
            <label for="registration_deadline">Registration Deadline:</label>
            <input type="date" name="registration_deadline" id="registration_deadline" value="2025-11-15" required>
        </div>
        
        <div>
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="draft">Draft</option>
                <option value="active" selected>Active</option>
                <option value="closed">Closed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        
        <div>
            <label for="max_participants">Max Participants:</label>
            <input type="number" name="max_participants" id="max_participants" value="5" min="1">
        </div>
        
        <div>
            <label for="allowed_talents">Allowed Talents (use IDs 1-10):</label>
            <select multiple name="allowed_talents[]" id="allowed_talents" required>
                <option value="1" selected>Drawing and Visual Arts</option>
                <option value="2" selected>Photography</option>
                <option value="3" selected>Graphic Design</option>
                <option value="4" selected>Music and Singing</option>
                <option value="5" selected>Public Speaking</option>
            </select>
        </div>
        
        <button type="submit">Create Competition</button>
    </form>
</body>
</html>