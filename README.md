# Website Design Questionnaire

This project consists of the client side questionnaire and a private admin dashboard for internal management of the questionnaires. 

## Project

This was an internal company project that I worked on in my free time outside of work. The task was to build an online questionnaire, based on existing PDF versions, for new clients to complete giving an insight into their specific styles and needs. 

## Structure

For brevity, the structure depicted below does not show every file and folder present in this repository. It gives a flavor of the structure and picks out some of the key files.

```
ee-questionnaire/
+-- application/
¦	+-- config/
¦		+-- form_validation.php
¦		+-- routes.php
¦		+-- ...
¦	+-- controllers/
¦		+-- dashboard.php
¦		+-- questions.php
¦		+-- ...
¦	+-- models/
¦		+-- charts_model.php
¦		+-- questionnaires_model.php
¦		+-- ...
¦	+-- views/
¦		+-- dashboard/
¦		+-- pdf/
¦		+-- questions/
¦			+-- cms.php
¦		+-- ...
+-- assets/
¦	+-- css/
¦	+-- js/
```

### Controllers

The **questions.php** controller prepares all the required data for displaying the questionnaire and loads any previous answers if the client is revisiting the form. The controller is also responsible for validating the form once submitted. It loads it's validation rules from a seperate config file, **form_validation.php**.

### Models

The admin dashboard for the questionnaires features 3 donut charts which highlight various statistics about the questionnaires that have been submitted so far. The **charts_model.php** model queries the database for the required chart data, packages it and returns it as an array. The **questionnaires_model.php** model deals with fetching questionnaire answers from the database and reading and updating the questionnaires progress.

### Views

The **dashboard views** cover most of the adminitrative appearance while the **questions views** deal with displaying the form elements for the actual questionnaire, **cms.php** in particular. The **PDF view** is an HTML template used to render a clients answers in a readable format ready for PDF generation.
