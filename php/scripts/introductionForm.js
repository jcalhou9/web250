// adds more fields to the form(introductionForm) dynamically for course and description
const addButton = document.getElementById('add-course-btn');
        if (addButton) {
            addButton.addEventListener('click', function () {
                const container = document.getElementById('courseList');
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'courses[]';
                input.placeholder = 'Course and description';
                input.className = 'course-input';
                container.insertBefore(input, addButton);
                input.focus();
            });
        }