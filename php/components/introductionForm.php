<!-- /components/introductionForm.php -->
<?php
    //default image and caption
    $imagePath = './images/self.jpg';
    $captionText = 'Downtown charlotte after a charity event';

    //default sections and their values
    $defaultSections = [
        'Background' => "Born and raised in Charlotte. I’m currently an automotive technician trying to make the switch to a new career in I.T.",
        'Academic Background' => "I have an associates degree in Automotive Systems Technology. Currently I’m working on an associates degree in Full Stack Computer Programming.",
        'Background In This Subject' => "The only background I have in this subject are the classes I have been taking for this degree.",
        'Primary Computer Platform' => "Windows 10 on a desktop",
        'Courses I\'m Taking & Why' => [
            "WEB215 - Advanced Markup and Scripting: I’m taking this course to further increase my knowledge of JS.",
            "WEB250 - Database Driven Websites: I’m taking this course to learn how to utilize databases with my websites.",
            "CSC221 - Advanced Python Programming: I’m taking this course to further increase my knowledge of Python."
        ],
        'Something I’m Excited/Nervous About' => "I am excited that this is my last semester but nervous about the job hunt."
    ];

    //initialize data with default values
    $submittedData = $defaultSections;
    $formSubmitted = false;
    
    //clean strings(validator was getting mad at me)
    function cleanString($text) {
        return preg_replace('/[^a-zA-Z0-9_-]/', '_', $text);
    }

    //form submission handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //move image to images folder and set the path if uploaded
        if (!empty($_FILES['imageFile']) && $_FILES['imageFile']['error'] === UPLOAD_ERR_OK) {
            $uploadPath = 'images/' . basename($_FILES['imageFile']['name']);
            move_uploaded_file($_FILES['imageFile']['tmp_name'], $uploadPath);
            $imagePath = $uploadPath;
        }
        //set caption text
        $captionText = $_POST['caption'] ?? $captionText;
        //loop through default sections and set data
        foreach ($defaultSections as $sectionTitle => $sectionValue) {
            $fieldName = cleanString($sectionTitle);
            //handle courses separately sinct there is more than one input
            $submittedData[$sectionTitle] = ($sectionTitle === "Courses I'm Taking & Why")
                ? ($_POST['courses'] ?? $sectionValue)
                : ($_POST[$fieldName] ?? $sectionValue);
        }
        //set form as submitted
        $formSubmitted = true;
    }
?>

<h2>Introduction Form</h2>

<!-- display form if not submitted -->
<?php if (!$formSubmitted): ?>
    <form method="post" enctype="multipart/form-data" class="intro-form">
        <label for="imageFile">Upload Image</label>
        <input type="file" id="imageFile" name="imageFile" accept="image/*">
        <label for="caption">Caption</label>
        <input type="text" id="caption" name="caption" value="<?= htmlspecialchars($captionText) ?>">
        <!-- provides fields for each section to be updated -->
        <?php foreach ($defaultSections as $sectionTitle => $sectionValue): ?>
            <!-- check if the section is a course list or a single input -->
            <?php if ($sectionTitle === "Courses I'm Taking & Why"): ?>
                <label><?= htmlspecialchars($sectionTitle) ?></label>
                <!-- displays field for each course and option to add more -->
                <fieldset id="courseList" class="course-list">
                    <?php foreach ($sectionValue as $line): ?>
                        <input type="text" name="courses[]" value="<?= htmlspecialchars($line) ?>" class="course-input">
                    <?php endforeach; ?>
                    <button type="button" id="add-course-btn" class="add-course">Add Course</button>
                </fieldset>
            <!-- handles the other sections -->
            <?php else:
                $fieldName = cleanString($sectionTitle); ?>
                <label for="<?= $fieldName ?>"><?= htmlspecialchars($sectionTitle) ?></label>
                <textarea id="<?= $fieldName ?>" name="<?= $fieldName ?>" rows="2"><?= htmlspecialchars($sectionValue) ?></textarea>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="form-buttons">
            <button type="submit">Update Introduction</button>
            <button type="submit" formaction="index.php" formmethod="get" name="content" value="introductionForm">Reset</button>
        </div>
    </form>

    <!-- script to add more course fields -->
    <script>
        
    </script>

<!-- displays the updated content when the form is submitted -->
<?php else: ?>
    <figure>
        <img src="<?= htmlspecialchars($imagePath) ?>" alt="Intro Image">
        <figcaption><?= htmlspecialchars($captionText) ?></figcaption>
    </figure>

    <dl>
        <?php foreach ($submittedData as $sectionTitle => $sectionValue): ?>
            <dt><strong><?= htmlspecialchars($sectionTitle) ?></strong></dt>
            <!-- handles the courses separately since there is more than one input -->
            <?php if ($sectionTitle === "Courses I'm Taking & Why"): ?>
                <?php foreach ($sectionValue as $line): ?>
                    <dd><?= htmlspecialchars($line) ?></dd>
                <?php endforeach; ?>
            <!-- handles the other sections -->
            <?php else: ?>
                <dd><?= htmlspecialchars($sectionValue) ?></dd>
            <?php endif; ?>
        <?php endforeach; ?>
    </dl>
    <!-- reloads page which sets formSubmitted to false -->
    <form method="get" action="index.php" class="intro-form form-buttons">
        <input type="hidden" name="content" value="introductionForm">
        <button type="submit">Reset</button>
    </form>
<?php endif; ?>