<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Index page
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'StudentCare';
$string['header'] = 'Manage Collections';
$string['report'] = 'Collections Dashboard';

// Strings for the collection form
$string['create_new_collection'] = 'Register New Collection';
$string['name'] = 'Collection Name';
$string['description'] = 'Description';
$string['starttime'] = 'Start Date and Time of the Collection';
$string['endtime'] = 'End Date and Time of the Collection';
$string['aeqclasses'] = 'Select an AEQ class';
$string['emotions'] = 'Select one or more emotions';
$string['select_course'] = 'Select the course';
$string['select_section'] = 'Select a section';
$string['select_resource'] = 'Select a resource or activity';
$string['alertprogress'] = 'Receive collection progress alert';
$string['notify_students'] = 'Notify students';
$string['submit'] = 'Save';
$string['update'] = 'Update';

// Validation and error messages
$string['endtimeerror'] = 'The end time must be later than the start time.';
$string['mensagem_sucesso'] = 'Registration successfully completed!';
$string['mensagem_erro'] = 'Error during registration. Please try again.';
$string['starttime_past_error'] = 'The start date cannot be in the past.';
$string['endtime_before_start_error'] = 'The end date must be later than the start date.';
$string['coleta_atualizada_com_sucesso'] = 'The collection was successfully updated.';
$string['erro_ao_atualizar_coleta'] = 'Error updating the collection data.';
$string['erro_ao_atualizar_emocoes'] = 'Error updating the associated emotions.';
$string['coleta_atualizada_com_sucesso'] = 'The collection was successfully updated.';

$string['editcoleta'] = 'Edit Collection';
$string['editcoleta_subtitle'] = 'Editing collection: {$a}';
$string['add-collection'] = 'Add New Collection';
$string['new_collection'] = 'New Collection';
$string['selection_summary'] = 'Selection Summary';

$string['search_label'] = 'Search';
$string['search_placeholder'] = 'Search by name, subject, description, resource type...';
$string['order_by_label'] = 'Order by';
$string['order_by_creation_date'] = 'Creation Date';
$string['order_by_collection_name'] = 'Collection Name';
$string['order_by_start_date'] = 'Start Date';
$string['order_by_end_date'] = 'End Date';
$string['order_by_course'] = 'Course';
$string['ascending'] = 'Ascending';
$string['descending'] = 'Descending';
$string['show_label'] = 'Show';
$string['show_5_per_page'] = '5 per page';
$string['show_10_per_page'] = '10 per page';
$string['show_15_per_page'] = '15 per page';
$string['show_20_per_page'] = '20 per page';

$string['preview_coleta'] = 'Preview Collection';
$string['link_coleta'] = 'Collection Link';
$string['disciplina'] = 'Course';
$string['data_inicio'] = 'Start Date';
$string['data_fim'] = 'End Date';
$string['nome_secao_vinculada'] = 'Linked Section Name';
$string['nome_atividade_recurso_vinculado'] = 'Linked Activity/Resource Name';
$string['notificar_aluno'] = 'Notify Student';
$string['receber_alerta'] = 'Receive Alert';
$string['descricao'] = 'Description';
$string['baixar_csv'] = 'Download CSV';
$string['baixar_json'] = 'Download JSON';
$string['editar'] = 'Edit';
$string['excluir'] = 'Delete';
$string['graficos'] = 'Graphs';

$string['course'] = 'Course';
$string['start_date'] = 'Start Date';
$string['end_date'] = 'End Date';
$string['details'] = 'Details';

$string['select_collection'] = 'Select a Collection';
$string['choose_option'] = '-- Choose --';

$string['select_collection_alert'] = 'Please select a collection before viewing the chart.';

$string['strongly_disagree'] = 'Strongly Disagree';
$string['disagree'] = 'Disagree';
$string['neutral'] = 'Neutral';
$string['agree'] = 'Agree';
$string['strongly_agree'] = 'Strongly Agree';

$string['stacked_bar'] = 'Stacked Bar';
$string['stacked_bar_description'] = 'Displays the distribution of responses by Likert scale.';
$string['view_chart'] = 'View Chart';

$string['collection_not_available'] = 'Sorry, this collection is no longer available. Please contact the administrator or teacher for more information.';

$string['collection_already_answered'] = 'Collection Already Answered';
$string['collection_already_answered_message'] = 'You have already answered this emotion collection. Thank you for your participation!';
$string['return_to_course'] = 'Return to the course';

$string['collection_not_started'] = 'The collection has not started yet.';
$string['collection_expired'] = 'The deadline to answer this collection expired on {datetime}.';
$string['date_format'] = '%d/%m/%Y %H:%M';

$string['no_questions_found'] = 'No questions were found for this collection. Please contact the teacher of the course <strong>{$a}</strong> for more information.';

$string['yes'] = 'Yes';
$string['no'] = 'No';

$string['dontlink'] = 'Do not link to any activity/resource';
$string['noemotion'] = 'No emotion registered for this collection.';

$string['tcle_title'] = 'Informed Consent Form (ICF)';
$string['tcle_description'] = 'Your participation in this emotion collection for the course <strong>{$a}</strong> is very important to us. By responding, you authorize the use of your answers, which will be treated confidentially and anonymously, exclusively for academic and pedagogical purposes. The collected information will be used in research aimed at improving teaching and learning, promoting a more welcoming and effective educational environment. Only the responsible teacher will have access to the data, safeguarding your privacy. We appreciate your collaboration!';
$string['tcle_accept'] = 'Accept';
$string['tcle_decline'] = 'Decline';

$string['back'] = 'Back';
$string['need_emotional_help'] = 'Need emotional help?';
$string['next'] = 'Next';

$string['feedback_title'] = 'What did you think of this collection?';
$string['feedback_placeholder'] = 'Write your feedback here...';
$string['feedback_submit'] = 'Submit Feedback';

$string['error_title'] = 'Attention';
$string['error_message'] = 'Please select an answer before proceeding.';
$string['understood'] = 'Understood';
$string['success_title'] = 'Collection Completed';
$string['success_message'] = 'You have completed all the questions in the collection. Thank you for participating!';
$string['return_to_course'] = 'Return to the course';

$string['faq_search_placeholder'] = 'Search by title or content...';
$string['faq_title'] = 'How can we help?';

// General strings for FAQ
$string['faq_topic_title'] = 'What is StudentCare?';
$string['faq_modal_header'] = '<i class="fas fa-info-circle"></i> What is StudentCare?';
$string['faq_modal_body'] = '<strong>StudentCare</strong> is a block plugin developed for the Moodle platform aimed at <em>monitoring academic emotions</em> of students. It is based on the <strong>AEQ (Achievement Emotions Questionnaire)</strong>, a widely recognized instrument for assessing emotions related to academic performance.';
$string['faq_functionalities_title'] = '<i class="fas fa-tools"></i> Key Features';
$string['faq_functionalities_list'] = '
    <li>Allows teachers to create <strong>emotion collections</strong>, selecting specific classes and emotions.</li>
    <li>Provides students with an interactive interface to answer collections using a Likert scale with emojis.</li>
    <li>Generates interactive graphs for teachers to view collected data, assisting in the analysis of academic emotions.</li>
    <li>Facilitates data export in formats like <i>CSV</i> and <i>JSON</i> for external analysis.</li>
';
$string['faq_objective_title'] = '<i class="fas fa-bullseye"></i> Objective';
$string['faq_objective_text'] = 'The main objective of <strong>StudentCare</strong> is to assist teachers and educational institutions in identifying and monitoring the academic emotions of students, contributing to more personalized and assertive pedagogical interventions, aiming to improve academic performance and reduce issues like demotivation and school dropout.';
$string['faq_benefits_title'] = '<i class="fas fa-graduation-cap"></i> Benefits';
$string['faq_benefits_list'] = '
    <li>Support in <strong>pedagogical planning</strong> based on students’ emotional data.</li>
    <li>Improvement in <strong>student engagement and well-being</strong>.</li>
    <li>Easy integration into Moodle, accessible to teachers and administrators.</li>
';

$string['faq_how_to_use_title'] = 'How to use the StudentCare plugin?';
$string['faq_how_to_use_intro'] = 'The StudentCare plugin is a powerful tool integrated into Moodle, allowing teachers to collect, monitor, and analyze academic emotions interactively and efficiently. Here is a guide to using it:';

$string['faq_topic_functionalities_title'] = 'Main functionalities of the StudentCare plugin';
$string['faq_topic_functionalities_description'] = '<strong>studentCare</strong> is a plugin developed to facilitate monitoring academic emotions in Moodle, providing several features designed for teachers and administrators. Here are some highlights:';
$string['faq_topic_functionalities_list'] = '<ul>
    <li><strong>📘 AEQ Manual:</strong> The plugin includes access to the <a href="/blocks/studentcare/manual_aeq.php" target="_blank">AEQ Manual</a>, which details the theoretical foundation and structure of the <em>Achievement Emotions Questionnaire (AEQ)</em>.</li>
    <li><strong>✍️ Collection registration and editing:</strong> Teachers can create new collections specific to their subjects, edit settings of existing collections, and choose which AEQ classes and emotions will be worked on.</li>
    <li><strong>🗑️ Deletion of collections:</strong> If necessary, collections can be easily removed by the teacher.</li>
    <li><strong>🔗 Resource linking:</strong> During registration, it is possible to associate a specific resource from a course section with the collection, further integrating class content with the collection.</li>
    <li><strong>🌐 Automatic creation of URL resource:</strong> For each collection created, the plugin automatically adds a URL resource to the section selected by the teacher.</li>
    <li><strong>📬 Customized notifications and emails:</strong> After registering a collection, customized notifications and emails for the course are automatically sent to students.</li>
    <li><strong>📝 Interactive TCLE:</strong> Before answering the collection, students view a Free and Informed Consent Term (TCLE) and can accept or decline it.</li>
    <li><strong>🤖 Interactive responses:</strong> AEQ questions are presented interactively based on the classes and emotions chosen by the teacher.</li>
    <li><strong>📊 Monitoring and alerts:</strong> Teachers can track the progress of the collection in real time and receive alerts about its progress.</li>
    <li><strong>📈 Results visualization:</strong> Collected data is displayed in interactive charts and reports, allowing practical and visual analysis of student emotions.</li>
    <li><strong>📂 Data export:</strong> Students’ responses can be exported in formats like JSON and CSV, facilitating external analysis or archiving.</li>
    <li><strong>📋 Centralized management:</strong> Installed in the Moodle dashboard, the plugin offers simplified and integrated management without the need for separate installation in each course.</li>
</ul>';
$string['faq_topic_functionalities_closing'] = 'These features make <strong>StudentCare</strong> a powerful and practical tool for understanding students’ academic emotions and improving the teaching and learning process.';

$string['faq_topic_developers_title'] = 'Who developed StudentCare?';
$string['faq_topic_developers_description'] = '<strong>StudentCare</strong> is a project developed as a Final Graduation Project (TCC) by the student <strong>Rafael Lariloran Costa Rodrigues</strong> (<a href="http://lattes.cnpq.br/1281350600184120" target="_blank">Lattes</a>), a student in the <em>Systems for Internet</em> course at the <strong>Federal Institute of Education, Science, and Technology of Rio Grande do Sul (IFRS) – Porto Alegre Campus</strong>.';
$string['faq_topic_developers_guidance'] = 'Guidance';
$string['faq_topic_developers_guidance_description'] = 'The project was supervised by <strong>Profa. Dra. Márcia Häfele Islabão Franco</strong> (<a href="http://lattes.cnpq.br/2551214616925074" target="_blank">Lattes</a>) and co-supervised by <strong>Prof. Dr. Marcelo Augusto Rauh Schmitt</strong> (<a href="http://lattes.cnpq.br/1958021878056697" target="_blank">Lattes</a>), both professors at IFRS Porto Alegre.';
$string['faq_topic_developers_contact'] = 'Contact';
$string['faq_topic_developers_contact_description'] = 'If you have found any <strong>bugs, issues, or have questions</strong>, send an email to:';

$string['start_here_title'] = 'Start here';
$string['start_here_description'] = '<strong>Achievement Emotions Questionnaire (AEQ)</strong> is a psychological assessment tool developed to measure students\' academic emotions in educational contexts. Created by <strong>Reinhard Pekrun</strong> and his collaborators, AEQ is based on the Control-Value Theory, which analyzes how emotions influence academic performance and motivation.';
$string['how_it_works'] = 'How it works?';
$string['start_here_questionnaire_description'] = 'AEQ uses a structured questionnaire with questions based on a <em>Likert</em> scale, where students assess their emotions related to three main situations:';
$string['emotion_classrooms'] = 'Class-related emotions';
$string['emotion_classrooms_description'] = 'Feelings like joy, boredom, and anger experienced before, during, and after attending classes.';
$string['emotion_study'] = 'Study-related emotions';
$string['emotion_study_description'] = 'Feelings like pride, frustration, and anxiety experienced during the learning process.';
$string['emotion_exams'] = 'Exam-related emotions';
$string['emotion_exams_description'] = 'Feelings like relief, hope, and shame before, during, and after exams.';
$string['how_to_use'] = 'How to use';
$string['start_here_usage'] = 'AEQ is widely used in educational and research contexts to:';
$string['evaluate_impact'] = 'Evaluate the impact of academic emotions on students\' performance.';
$string['identify_patterns'] = 'Identify emotional patterns that may lead to demotivation or school dropout.';
$string['assist_educators'] = 'Assist educators and administrators in developing pedagogical strategies that promote an emotionally healthy environment.';
$string['purpose'] = 'Purpose';
$string['main_objective'] = 'The main goal of AEQ is to provide a tool to understand academic emotions and their role in learning, helping to improve the educational experience and reduce emotional barriers to academic success.';
$string['classes_aeq'] = 'AEQ Classes';
$string['what_are_aeq_classes'] = 'What are AEQ Classes?';
$string['aeq_classes_description'] = 'The AEQ classes are categories that group academic emotions based on the context in which they occur. Each class is designed to assess emotions experienced before, during, and after specific academic activities, such as attending classes, studying, or taking exams. These moments are critical as they represent the most emotionally impactful situations in a student\'s academic trajectory.';
$string['classroom_related_emotions'] = 'Class-Related Emotions';
$string['classroom_emotions_description'] = 'This class assesses the emotions experienced while participating in classes (<i>Class-Related Emotions</i>). It includes feelings experienced before entering the classroom (such as expectation or nervousness), during the class (such as interest or frustration), and after the class (such as relief or pride).';
$string['learning_related_emotions'] = 'Learning-Related Emotions';
$string['learning_emotions_description'] = 'Focused on the emotions associated with the study or learning process (<i>Learning-Related Emotions</i>), this class addresses the feelings that arise before starting a study session (such as motivation or discouragement), during study (such as concentration or irritation), and after studying (such as satisfaction or frustration).';
$string['test_related_emotions'] = 'Test-Related Emotions';
$string['test_emotions_description'] = 'This class examines the emotions experienced during evaluation moments, such as tests and exams (<i>Test-Related Emotions</i>). It considers feelings experienced before a test (such as anxiety or confidence), during the test (such as nervousness or focus), and after the test (such as relief or shame).';


$string['academic_emotions'] = 'Academic Emotions';
$string['aeq_description'] = 'The <strong>Achievement Emotions Questionnaire (AEQ)</strong> works with a wide range of academic emotions (<i>Achievement Emotions</i>), organized into three main contexts: classes, study, and exams. Here are the emotions assessed in each context and what they represent:';
$string['classroom_related_emotions'] = 'Classroom-Related Emotions';
$string['classroom_joy_description'] = 'Feeling of pleasure and enthusiasm when attending classes.';
$string['classroom_hope_description'] = 'Confidence that it will be possible to follow the content and participate actively.';
$string['classroom_pride_description'] = 'Satisfaction from understanding the content or contributing positively.';
$string['classroom_anger_description'] = 'Frustration or irritation caused by the dynamics or quality of the class.';
$string['classroom_anxiety_description'] = 'Restlessness or nervousness related to the environment or the content of the class.';
$string['classroom_shame_description'] = 'Embarrassment due to difficulties in expressing or understanding the content.';
$string['classroom_hopelessness_description'] = 'Feeling of giving up or lack of perspective regarding the learning process.';
$string['classroom_boredom_description'] = 'Feeling of monotony or lack of interest in the class.';
$string['learning_related_emotions'] = 'Learning-Related Emotions';
$string['learning_joy_description'] = 'Pleasure in learning and exploring new knowledge.';
$string['learning_hope_description'] = 'Optimism about the ability to master the studied material.';
$string['learning_pride_description'] = 'Satisfaction from the results achieved during the study process.';
$string['learning_anger_description'] = 'Irritation with the amount of material or difficulties in studying.';
$string['learning_anxiety_description'] = 'Fear or tension faced with difficulties in learning.';
$string['learning_shame_description'] = 'Embarrassment from not being able to absorb or apply the content properly.';
$string['learning_hopelessness_description'] = 'Demotivation from believing that one will not be able to understand or progress in the study.';
$string['learning_boredom_description'] = 'Feeling of disinterest when dealing with monotonous or unstimulating material.';
$string['test_related_emotions'] = 'Test-Related Emotions';
$string['test_joy_description'] = 'Satisfaction from demonstrating knowledge or facing challenges in tests.';
$string['test_hope_description'] = 'Confidence in good performance and success in the evaluation.';
$string['test_pride_description'] = 'Satisfaction from preparation efforts and performance in the test.';
$string['test_relief_description'] = 'Feeling of relief upon completing an evaluation.';
$string['test_anger_description'] = 'Frustration with time, difficulty, or perceived injustice in the test.';
$string['test_anxiety_description'] = 'Intense worry before or during the evaluation.';
$string['test_shame_description'] = 'Embarrassment from unsatisfactory performance or mistakes made.';
$string['test_hopelessness_description'] = 'Feeling of giving up or lack of confidence in the success of the test.';

$string['aeq_questions'] = 'AEQ Questions';
$string['manual_aeq_title'] = 'Guide for Using the AEQ';
$string['aeq_description'] = 'The <strong>Achievement Emotions Questionnaire (AEQ)</strong> questions were developed to measure academic emotions in a structured way, across three main contexts: classes, study, and tests/exams. They assess the emotions experienced before, during, and after each of these situations.';
$string['how_it_works'] = 'How It Works?';
$string['how_it_works_description'] = 'Each question presents a statement describing an emotional state. Students evaluate how this statement reflects their personal experiences using a Likert scale ranging from 1 (strongly disagree) to 5 (strongly agree).';
$string['example_questions'] = 'Example Questions';
$string['classroom_related'] = 'Classroom-Related';
$string['example_classroom_question'] = 'I get excited to go to class.';
$string['study_related'] = 'Study-Related';
$string['example_study_question'] = 'I feel optimistic about my progress in my studies.';
$string['test_related'] = 'Test-Related';
$string['example_test_question'] = 'I get anxious before an exam.';
$string['question_organization'] = 'Question Organization';
$string['question_organization_description'] = 'The questions are organized into blocks that help participants access specific memories, making the answers more representative. This structure helps to better understand how emotions affect academic performance.';

$string['start_here'] = 'Start here';


$string['faq_how_to_use_teacher_steps_title'] = '👩‍🏫 Steps for teachers to register a collection:';
$string['faq_teacher_step_1'] = '📋 Access the StudentCare plugin panel: Locate the plugin directly in the Moodle panel to facilitate centralized management, without the need for installation in specific courses.';
$string['faq_teacher_step_2'] = '📚 Fill in the collection information: Add start and end dates and an optional description.';
$string['faq_teacher_step_3'] = '📝 Choose the course, section, and resource: Link the collection to a course and select a specific section. If needed, associate the collection with an existing resource.';
$string['faq_teacher_step_4'] = '🎭 Select AEQ classes and emotions: Use the form to choose academic emotion classes (classes, learning, tests) and specific emotions. These selections will define the questions students will answer.';
$string['faq_teacher_step_5'] = '🔔 Configure notifications and alerts: Enable automatic notifications for students and receive alerts about the progress of the collection.';

$string['faq_after_registration_title'] = '📊 After registering the collection:';
$string['faq_after_registration_export'] = '📤 Data export: Response data can be exported in formats like JSON and CSV for more detailed analysis.';
$string['faq_after_registration_graphs'] = '📈 Graph visualization: Teachers can access interactive reports with graphs to interpret the collected data and adjust pedagogical strategies as needed.';
$string['faq_after_registration_delete'] = '❌ Deleting collections: If the collection is no longer needed, teachers can delete it directly from the plugin panel.';

$string['faq_for_students_title'] = '👨‍🎓 For students:';
$string['faq_students_notifications'] = '🔔 Receive personalized notifications: Students are notified via email and Moodle about available collections.';
$string['faq_students_answer'] = '📝 Answer collections: The questions are displayed interactively on a Likert scale from 1 to 5, based on the classes and emotions selected by the teacher.';
$string['faq_students_tcle'] = '📜 Accept or decline the TCLE: Before answering the questions, students must accept or decline the Free and Informed Consent Term (TCLE).';

$string['faq_additional_resources_title'] = '📘 Additional resources:';
$string['faq_resources_manual'] = '📖 AEQ Manual: The plugin provides the <a href=\'/blocks/studentcare/manual_aeq.php\'>AEQ Manual</a>, which details AEQ classes, emotions, and questions.';
$string['faq_resources_auto_creation'] = '🌐 Automatic resource creation: After registration, the plugin automatically creates a URL-type resource linked to the section chosen by the teacher, facilitating student access.';
$string['faq_resources_graphs'] = '📊 Graphs and reports: Response data is displayed in interactive graphs for easy analysis.';

$string['faq_how_to_use_conclusion'] = 'The StudentCare plugin is designed to be intuitive and efficient, optimizing the process of collecting and analyzing academic emotions. It helps create pedagogical strategies based on real data, promoting a healthier and more adaptive learning environment.';

$string['coleta_limitada_aviso'] = 'The collection started on {$a->datainicio}. Some changes are limited. For more details about this collection, return to the <a href="{$a->listagemurl}">list</a>.';
$string['coleta_atualizada_com_sucesso'] = 'The collection was successfully updated.';
$string['returntolist'] = 'Return to the list';

$string['collection_title'] = 'StudentCare - How are you feeling today?';
$string['collection_intro'] = 'Please complete this survey <strong>by</strong> {date}. Participate and help us better understand your emotions!';

$string['event_subject'] = 'StudentCare - Share your emotions about the course {disciplina}';
$string['event_fullmessage'] = 'Hello! An emotion collection for the course {disciplina} has been created and is available until {datafim} for you to respond. Your feedback is very important. Please participate!';
$string['event_fullmessagehtml'] = '<p>Hello!</p>
<p>An emotion collection for the course <strong>{disciplina}</strong> has been created and is available until <strong>{datafim}</strong> for you to respond.</p>
<p>Your feedback is very important to us. <a href="{url}">Click here</a> to share your emotions and help us improve your learning experience.</p>';
$string['event_smallmessage'] = 'An emotion collection for the course {disciplina} has been created and is available until {datafim}. <a href="{url}">Click here</a> to participate.';


// Management and navigation strings
$string['manage_collections'] = 'Manage Collections';
$string['view_dashboard'] = 'Collections Dashboard';
$string['manual_aeq'] = 'AEQ Manual';
$string['faq'] = 'Frequently Asked Questions (FAQ)';
$string['process_collection'] = 'Process Collection';

$string['messageprovider:created_collection'] = 'Notification sent to students when a new collection is created.';
$string['studentcare:addinstance'] = 'Add a new instance of the StudentCare block';
$string['studentcare:myaddinstance'] = 'Add a new instance of the StudentCare block to the dashboard';
$string['studentcare:receivenotifications'] = 'Receive notifications about collections created in StudentCare';
$string['studentcare:managecollections'] = 'Manage the StudentCare block';
$string['manual_aeq_search_placeholder'] = 'Search by title or content...';
$string['chart_title'] = 'Distribution of Responses by Likert Scale';

$string['yes_en'] = 'Yes';
$string['no_en'] = 'No';

$string['confirm_title'] = 'Confirmation';
$string['confirm_message'] = 'Do you want to save the information of this emotion collection?';
$string['confirm_message_update'] = 'Do you want to modify the information for this emotion collection?';
$string['confirm_message_delete'] = 'Are you sure you want to delete the collection? This action cannot be undone and all related data will be removed.';
$string['confirm_button_yes'] = 'Confirm';
$string['confirm_button_no'] = 'Cancel';

$string['questions_referring'] = 'The following questions refer to';
$string['plural_emotions'] = 'emotions';
$string['singular_emotion'] = 'emotion';
$string['that_you_can_feel'] = 'that you can feel';
$string['before'] = 'before';
$string['during'] = 'during';
$string['after'] = 'after';
// No arquivo lang/en/block_studentcare.php
$string['in_course'] = 'from the class';
$string['from_course'] = 'of the course';
$string['from_class'] = 'from the classes of';
$string['from_study'] = 'from studying';
$string['from_assessment'] = 'from the assessment activity';

$string['please_read_each_item'] = 'Please read each item carefully and respond using the provided scale.';

// Welcome message
$string['welcome'] = 'Welcome to StudentCare!';

// Classes
$string['class-related'] = 'Class-Related Emotions';
$string['learning-related'] = 'Learning-Related Emotions';
$string['test-related'] = 'Test-Related Emotions';

// Emotions
$string['anger'] = 'Anger';
$string['joy'] = 'Joy';
$string['anxiety'] = 'Anxiety';
$string['shame'] = 'Shame';
$string['hopelessness'] = 'Hopelessness';
$string['boredom'] = 'Boredom';
$string['hope'] = 'Hope';
$string['pride'] = 'Pride';
$string['relief'] = 'Relief';
$string['enjoyment'] = 'Enjoyment';

$string['emotion-colect'] = 'Emotion Collection';

$string['anger-txttooltip'] = 'An intense emotion, often resulting from frustration or injustice, that can lead to impulsive actions.';
$string['anxiety-txttooltip'] = 'A feeling of worry, nervousness, or fear about future events or uncertain situations.';
$string['shame-txttooltip'] = 'An uncomfortable or painful feeling caused by the perception that something you did or said was wrong or embarrassing.';
$string['hopelessness-txttooltip'] = 'A feeling of complete lack of hope, where it seems that there are no solutions or escapes from a difficult situation.';
$string['boredom-txttooltip'] = 'A state of disinterest or lack of stimulation, often associated with repetition or the absence of challenges.';
$string['hope-txttooltip'] = 'An optimistic feeling about the future, believing that something good will happen.';
$string['pride-txttooltip'] = 'A feeling of satisfaction with oneself or others for achievements, success, or abilities.';
$string['relief-txttooltip'] = 'A feeling of calm and comfort that arises when a stressful, difficult, or painful situation comes to an end or is resolved.';
$string['enjoyment-txttooltip'] = 'A sense of satisfaction and well-being, usually associated with pleasant and positive experiences.';

///Tooltips
$string['select_section_help'] = 'Choose the section where you want to conduct the emotion collection. Each section represents a course module or week. When selecting a section, a <strong>URL</strong> type resource will automatically be created in the chosen section.';
$string['select_resource_help'] = 'Choose the resource you want to link to the emotion collection. Each resource represents an activity or material within the course. When selecting the resource, it will be automatically linked to the emotion collection in the corresponding section.';
$string['aeqclasses_help'] = 'Choose the AEQ classes you want to use in the emotion collection. AEQ classes represent different categories of academic emotions. To learn more about AEQ classes, consult the <strong>AEQ Manual</strong> section in the block panel.';
$string['emotions_help'] = 'Choose the emotions you want to include in the collection. Each selected emotion will display a different set of related questions during the collection, allowing a detailed analysis of academic emotions. The emotions are associated with AEQ classes, which represent different categories of academic emotions. To learn more about the emotions and their classifications, check the information in the <strong>AEQ Manual</strong> available in the block panel.';
$string['alertprogress_help'] = 'Enable this option to send a notification when the collection is completed. When enabled, an email notification and a Moodle pop-up will inform you that the emotion collection has been completed.';
$string['notify_students_help'] = 'Enable this option to send a notification to students when a new collection is created. When enabled, students will receive an email notification and a Moodle pop-up informing them about the creation of the emotion collection.';

// Perguntas class related
$string['class-related-enjoyment-1'] = 'I get excited about going to class. ';
$string['class-related-enjoyment-2'] = 'I enjoy being in class.';
$string['class-related-enjoyment-3'] = 'After class I start looking forward to the next class.';
$string['class-related-enjoyment-4'] = 'I am looking forward to learning a lot in this class.';
$string['class-related-enjoyment-5'] = 'I am happy that I understood the material.';
$string['class-related-enjoyment-6'] = 'I am glad that it paid off to go to class.';
$string['class-related-enjoyment-7'] = 'I am motivated to go to this class because it’s exciting. ';
$string['class-related-enjoyment-8'] = 'My enjoyment of this class makes me want to participate.';
$string['class-related-enjoyment-9'] = 'It’s so exciting that I could sit in class for hours listening to the professor.';
$string['class-related-enjoyment-10'] = 'I enjoy participating so much that I get energized.';

$string['class-related-hope-1'] = 'I am confident when I go to class.';
$string['class-related-hope-2'] = 'I am full of hope. ';
$string['class-related-hope-3'] = 'I am optimistic that I will be able to keep up with the material.';
$string['class-related-hope-4'] = 'I am hopeful that I will make good contributions in class.';
$string['class-related-hope-5'] = 'I am confident because I understand the material.';
$string['class-related-hope-6'] = 'Being confident that I will understand the material motivates me.';
$string['class-related-hope-7'] = 'My confidence motivates me to prepare for class. ';
$string['class-related-hope-8'] = 'My hopes that I will be successful motivate me to invest a lot of effort.';

$string['class-related-pride-1'] = 'I am proud of myself.';
$string['class-related-pride-2'] = 'I take pride in being able to keep up with the material.';
$string['class-related-pride-3'] = 'I am proud that I do better than the others in this course. ';
$string['class-related-pride-4'] = 'I think that I can be proud of what I know about this subject.';
$string['class-related-pride-5'] = 'I am proud of the contributions I have made in class.';
$string['class-related-pride-6'] = 'When I make good contributions in class, I get even more motivated.';
$string['class-related-pride-7'] = 'Because I take pride in my accomplishments in this course, I am motivated to continue.';
$string['class-related-pride-8'] = 'I would like to tell my friends about how well I did in this course.';
$string['class-related-pride-9'] = 'When I do well in class, my heart throbs with pride.';

$string['class-related-anger-1'] = 'I feel frustrated in class. ';
$string['class-related-anger-2'] = 'I am angry.';
$string['class-related-anger-3'] = 'Thinking about the poor quality of the course makes me angry.';
$string['class-related-anger-4'] = 'Thinking about all the useless things I have to learn makes me irritated.';
$string['class-related-anger-5'] = 'When I think of the time I waste in class I get aggravated.';
$string['class-related-anger-6'] = 'I wish I didn’t have to attend class because it makes me angry.';
$string['class-related-anger-7'] = 'I wish I could tell the teachers off.';
$string['class-related-anger-8'] = 'I feel anger welling up in me. ';
$string['class-related-anger-9'] = 'Because I’m angry I get restless in class. ';

$string['class-related-anxiety-1'] = 'Thinking about class makes me feel uneasy.';
$string['class-related-anxiety-2'] = 'I feel scared.';
$string['class-related-anxiety-3'] = 'I feel nervous in class.';
$string['class-related-anxiety-4'] = 'Even before class, I worry whether I will be able to understand the material.';
$string['class-related-anxiety-5'] = 'I worry whether I’m sufficiently prepared for the lesson. ';
$string['class-related-anxiety-6'] = 'I worry whether the demands might be too great.';
$string['class-related-anxiety-7'] = 'I worry the others will understand more than me.';
$string['class-related-anxiety-8'] = 'Because I’m so nervous I would rather skip the class.';
$string['class-related-anxiety-9'] = 'I get scared that I might say something wrong, so I’d rather not say anything.';
$string['class-related-anxiety-10'] = 'When I think about class, I get queasy. ';
$string['class-related-anxiety-11'] = 'I get tense in class.';
$string['class-related-anxiety-12'] = 'When I don’t understand something important in class, my heart races.';

$string['class-related-shame-1'] = 'I get embarrassed.';
$string['class-related-shame-2'] = 'I am ashamed.';
$string['class-related-shame-3'] = 'If the others knew that I don’t understand the material I would be embarrassed.';
$string['class-related-shame-4'] = 'When I say anything in class I feel like I am making a fool of myself.';
$string['class-related-shame-5'] = 'I’m embarrassed that I can’t express myself well.';
$string['class-related-shame-6'] = 'I am ashamed because others understood more of the lecture than I did.';
$string['class-related-shame-7'] = 'After I have said something in class I wish I could crawl into a hole and hide.';
$string['class-related-shame-8'] = 'I’d rather not tell anyone when I don’t understand something in class.';
$string['class-related-shame-9'] = 'When I say something in class I feel like I turn red.';
$string['class-related-shame-10'] = 'Because I get embarrassed, I become tense and inhibited.';
$string['class-related-shame-11'] = 'When I talk in class I start stuttering.';

$string['class-related-hopelessness-1'] = 'The thought of this class makes me feel hopeless.';
$string['class-related-hopelessness-2'] = 'I feel hopeless.';
$string['class-related-hopelessness-3'] = 'Even before class, I am resigned to the fact that I won’t understand the material.';
$string['class-related-hopelessness-4'] = 'I have lost all hope in understanding this class.';
$string['class-related-hopelessness-5'] = 'I feel hopeless continuing in this program of studies.';
$string['class-related-hopelessness-6'] = 'Because I’ve given up, I don’t have energy to go to class.';
$string['class-related-hopelessness-7'] = 'I’d rather not go to class since there is no hope of understanding the material anyway.';
$string['class-related-hopelessness-8'] = 'It’s pointless to prepare for class since I don’t understand the material anyway.';
$string['class-related-hopelessness-9'] = 'Because I don’t understand the material I look disconnected and resigned.';
$string['class-related-hopelessness-10'] = 'I feel so hopeless all my energy is depleted.';

$string['class-related-boredom-1'] = 'I get bored.';
$string['class-related-boredom-2'] = 'I find this class fairly dull.';
$string['class-related-boredom-3'] = 'The lecture bores me.';
$string['class-related-boredom-4'] = 'Because I get bored my mind begins to wander.';
$string['class-related-boredom-5'] = 'I’m tempted to walk out of the lecture because it is so boring.';
$string['class-related-boredom-6'] = 'I think about what else I might be doing rather than sitting in this boring class.';
$string['class-related-boredom-7'] = 'Because the time drags I frequently look at my watch.';
$string['class-related-boredom-8'] = 'I get so bored I have problems staying alert.';
$string['class-related-boredom-9'] = 'I get restless because I can’t wait for the class to end.';
$string['class-related-boredom-10'] = 'During class I feel like I could sink into my chair.';
$string['class-related-boredom-11'] = 'I start yawning in class because I’m so bored.';

// Perguntas learning related
$string['learning-related-enjoyment-1'] = 'I look forward to studying.';
$string['learning-related-enjoyment-2'] = 'I enjoy the challenge of learning the material.';
$string['learning-related-enjoyment-3'] = 'I enjoy acquiring new knowledge.';
$string['learning-related-enjoyment-4'] = 'I enjoy dealing with the course material.';
$string['learning-related-enjoyment-5'] = 'Reflecting on my progress in coursework makes me happy.';
$string['learning-related-enjoyment-6'] = 'I study more than required because I enjoy it so much.';
$string['learning-related-enjoyment-7'] = 'I am so happy about the progress I made that I am motivated to continue studying.';
$string['learning-related-enjoyment-8'] = 'Certain subjects are so enjoyable that I am motivated to do extra readings about them.';
$string['learning-related-enjoyment-9'] = 'When my studies are going well, it gives me a rush.';
$string['learning-related-enjoyment-10'] = 'I get physically excited when my studies are going well.';

$string['learning-related-hope-1'] = 'I have an optimistic view toward studying.';
$string['learning-related-hope-2'] = 'I feel confident when studying. ';
$string['learning-related-hope-3'] = 'I feel confident that I will be able to master the material.';
$string['learning-related-hope-4'] = 'I feel optimistic that I will make good progress at studying.';
$string['learning-related-hope-5'] = 'The thought of achieving my learning objectives inspires me.';
$string['learning-related-hope-6'] = 'My sense of confidence motivates me.';

$string['learning-related-pride-1'] = 'I’m proud of myself.';
$string['learning-related-pride-2'] = 'I’m proud of my capacity.';
$string['learning-related-pride-3'] = 'I think I can be proud of my accomplishments at studying.';
$string['learning-related-pride-4'] = 'Because I want to be proud of my accomplishments, I am very motivated.';
$string['learning-related-pride-5'] = 'When I solve a difficult problem in my studying, my heart beats with pride.';
$string['learning-related-pride-6'] = 'When I excel at my work, I swell with pride.';

$string['learning-related-anger-1'] = 'I get angry when I have to study.';
$string['learning-related-anger-2'] = 'Studying makes me irritated.';
$string['learning-related-anger-3'] = 'I get angry while studying.';
$string['learning-related-anger-4'] = 'I’m annoyed that I have to study so much.';
$string['learning-related-anger-5'] = 'I get annoyed about having to study.';
$string['learning-related-anger-6'] = 'Because I get so upset over the amount of material, I don’t even want to begin studying.';
$string['learning-related-anger-7'] = 'I get so angry I feel like throwing the textbook out of the window. ';
$string['learning-related-anger-8'] = 'When I sit at my desk for a long time, my irritation makes me restless.';
$string['learning-related-anger-9'] = 'After extended studying, I’m so angry that I get tense.';

$string['learning-related-anxiety-1'] = 'When I look at the books I still have to read, I get anxious.';
$string['learning-related-anxiety-2'] = 'I get tense and nervous while studying. ';
$string['learning-related-anxiety-3'] = 'When I can’t keep up with my studies it makes me fearful.';
$string['learning-related-anxiety-4'] = 'I worry whether I’m able to cope with all my work.';
$string['learning-related-anxiety-5'] = 'The subject scares me since I don’t fully understand it. ';
$string['learning-related-anxiety-6'] = 'I worry whether I have properly understood the material. ';
$string['learning-related-anxiety-7'] = 'I get so nervous that I don’t even want to begin to study.';
$string['learning-related-anxiety-8'] = 'While studying I feel like distracting myself in order to reduce my anxiety.';
$string['learning-related-anxiety-9'] = 'When I have to study I start to feel queasy.';
$string['learning-related-anxiety-10'] = 'As time runs out my heart begins to race.';
$string['learning-related-anxiety-11'] = 'Worry about not completing the material makes me sweat.';

$string['learning-related-shame-1'] = 'I feel ashamed.';
$string['learning-related-shame-2'] = 'I feel ashamed about my constant procrastination.';
$string['learning-related-shame-3'] = 'I feel ashamed that I can’t absorb the simplest of details. ';
$string['learning-related-shame-4'] = 'I feel ashamed because I am not as adept as others in studying.';
$string['learning-related-shame-5'] = 'I feel embarrassed about not being able to fully explain the material to others.';
$string['learning-related-shame-6'] = 'I feel ashamed when I realize that I lack ability.';
$string['learning-related-shame-7'] = 'My memory gaps embarrass me.';
$string['learning-related-shame-8'] = 'Because I have had so much troubles with the course material, I avoid discussing it.';
$string['learning-related-shame-9'] = 'I don’t want anybody to know when I haven’t been able to understand something.';
$string['learning-related-shame-10'] = 'When somebody notices how little I understand I avoid eye contact.';
$string['learning-related-shame-11'] = 'I turn red when I don’t know the answer to a question relating to the course material.';

$string['learning-related-hopelessness-1'] = 'I feel hopeless when I think about studying.';
$string['learning-related-hopelessness-2'] = 'I feel helpless. ';
$string['learning-related-hopelessness-3'] = 'I feel resigned.';
$string['learning-related-hopelessness-4'] = 'I’m resigned to the fact that I don’t have the capacity to master this material.';
$string['learning-related-hopelessness-5'] = 'After studying I’m resigned to the fact that I haven’t got the ability.';
$string['learning-related-hopelessness-6'] = 'I’m discouraged about the fact that I’ll never learn the material.';
$string['learning-related-hopelessness-7'] = 'I worry because my abilities are not sufficient for my program of studies.';
$string['learning-related-hopelessness-8'] = 'I feel so helpless that I can’t give my studies my full efforts.';
$string['learning-related-hopelessness-9'] = 'I wish I could quit because I can’t cope with it.';
$string['learning-related-hopelessness-10'] = 'My lack of confidence makes me exhausted before I even start.';
$string['learning-related-hopelessness-11'] = 'My hopelessness undermines all my energy. ';

$string['learning-related-boredom-1'] = 'The material bores me to death.';
$string['learning-related-boredom-2'] = 'Studying for my courses bores me.';
$string['learning-related-boredom-3'] = 'Studying is dull and monotonous.';
$string['learning-related-boredom-4'] = 'While studying this boring material, I spend my time thinking of how time stands still. ';
$string['learning-related-boredom-5'] = 'The material is so boring that I find myself daydreaming.';
$string['learning-related-boredom-6'] = 'I find my mind wandering while I study.';
$string['learning-related-boredom-7'] = 'Because I’m bored I have no desire to learn.';
$string['learning-related-boredom-8'] = 'I would rather put off this boring work till tomorrow.';
$string['learning-related-boredom-9'] = 'Because I’m bored I get tired sitting at my desk.';
$string['learning-related-boredom-10'] = 'The material bores me so much that I feel depleted.';
$string['learning-related-boredom-11'] = 'While studying I seem to drift off because it’s so boring.';


// Perguntas test related
$string['test-related-enjoyment-1'] = 'I look forward to the exam.';
$string['test-related-enjoyment-2'] = 'I enjoy taking the exam.';
$string['test-related-enjoyment-3'] = 'I look forward to demonstrating my knowledge.';
$string['test-related-enjoyment-4'] = 'I am happy that I can cope with the test. ';
$string['test-related-enjoyment-5'] = 'For me the test is a challenge that is enjoyable.';
$string['test-related-enjoyment-6'] = 'Because I enjoy preparing for the test, I’m motivated to do more than is necessary.';
$string['test-related-enjoyment-7'] = 'Because I look forward to being successful, I study hard.';
$string['test-related-enjoyment-8'] = 'Before taking the exam, I sense a feeling of eagerness. ';
$string['test-related-enjoyment-9'] = 'My heart beats faster with joy. ';
$string['test-related-enjoyment-10'] = 'I glow all over.';

$string['test-related-hope-1'] = 'I am optimistic that everything will work out fine.';
$string['test-related-hope-2'] = 'I am very confident.';
$string['test-related-hope-3'] = 'I have great hope that my abilities will be sufficient.';
$string['test-related-hope-4'] = 'I’m quite confident that my preparation is sufficient.';
$string['test-related-hope-5'] = 'I think about my exam optimistically.';
$string['test-related-hope-6'] = 'I start studying for the exam with great hope and anticipation.';
$string['test-related-hope-7'] = 'My confidence motivates me to prepare well.';
$string['test-related-hope-8'] = 'Hoping for success, I’m motivated to invest a lot of effort.';

$string['test-related-pride-1'] = 'I am very satisfied with myself.';
$string['test-related-pride-2'] = 'I am proud of myself. ';
$string['test-related-pride-3'] = 'I think that I can be proud of my knowledge.';
$string['test-related-pride-4'] = 'To think about my success makes me feel proud.';
$string['test-related-pride-5'] = 'I’m proud of how well I mastered the exam.';
$string['test-related-pride-6'] = 'I’m so proud of my preparation that I want to start the exam now.';
$string['test-related-pride-7'] = 'Pride in my knowledge fuels my efforts in doing the test.';
$string['test-related-pride-8'] = 'When I get the test results back, my heart beats with pride.';
$string['test-related-pride-9'] = 'After the exam I feel ten feet taller because I’m so proud.';
$string['test-related-pride-10'] = 'I walk out of the exam with the look of a winner on my face. ';

$string['test-related-relief-1'] = 'I feel relief.';
$string['test-related-relief-2'] = 'I feel freed.';
$string['test-related-relief-3'] = 'I feel very relieved.';
$string['test-related-relief-4'] = 'The tension in my stomach is dissipated.';
$string['test-related-relief-5'] = 'I finally can breathe easy again.';
$string['test-related-relief-6'] = 'I can finally laugh again.';

$string['test-related-anger-1'] = 'I get angry.';
$string['test-related-anger-2'] = 'I am fairly annoyed.';
$string['test-related-anger-3'] = 'I get angry over time pressures which don’t leave  enough time to prepare.';
$string['test-related-anger-4'] = 'I get angry about the amount of material I need to know.';
$string['test-related-anger-5'] = 'I think the questions are unfair.';
$string['test-related-anger-6'] = 'I get angry about the teacher’s grading standards.';
$string['test-related-anger-7'] = 'I wish I could tell the teacher off. ';
$string['test-related-anger-8'] = 'I wish I could freely express my anger.';
$string['test-related-anger-9'] = 'My anger makes the blood rush to my head.';
$string['test-related-anger-10'] = 'I get so angry, I start feeling hot and flushed.';

$string['test-related-anxiety-1'] = 'Before the exam I feel nervous and uneasy.';
$string['test-related-anxiety-2'] = 'I am very nervous.';
$string['test-related-anxiety-3'] = 'I feel panicky when writing the exam.';
$string['test-related-anxiety-4'] = 'I worry whether I have studied enough.';
$string['test-related-anxiety-5'] = 'I worry whether the test will be too difficult.';
$string['test-related-anxiety-6'] = 'I worry whether I will pass the exam.';
$string['test-related-anxiety-7'] = 'I get so nervous I wish I could just skip the exam.';
$string['test-related-anxiety-8'] = 'I get so nervous I can’t wait for the exam to be over.';
$string['test-related-anxiety-9'] = 'I am so anxious that I’d rather be anywhere else.';
$string['test-related-anxiety-10'] = 'I feel sick to my stomach.';
$string['test-related-anxiety-11'] = 'At the beginning of the test, my heart starts pounding.';
$string['test-related-anxiety-12'] = 'My hands get shaky.';

$string['test-related-shame-1'] = 'I feel humiliated.';
$string['test-related-shame-2'] = 'I feel ashamed.';
$string['test-related-shame-3'] = 'I can’t even think about how embarrassing it would be to fail the exam.';
$string['test-related-shame-4'] = 'I am ashamed of my poor preparation.';
$string['test-related-shame-5'] = 'I get embarrassed because I can’t answer the questions correctly.';
$string['test-related-shame-6'] = 'My marks embarrass me.';
$string['test-related-shame-7'] = 'I get so embarrassed I want to run and hide.';
$string['test-related-shame-8'] = 'When I get a bad mark I would prefer not to face my teacher again.';
$string['test-related-shame-9'] = 'Because I am ashamed my pulse races.';
$string['test-related-shame-10'] = 'When others find out about my poor marks I start to blush.';

$string['test-related-hopelessness-1'] = 'I get depressed because I feel I don’t have much hope for the exam.';
$string['test-related-hopelessness-2'] = 'I feel hopeless.';
$string['test-related-hopelessness-3'] = 'I have lost all hope that I have the ability to do well on the exam.';
$string['test-related-hopelessness-4'] = 'I have given up believing that I can answer the questions correctly.';
$string['test-related-hopelessness-5'] = 'I start to think that no matter how hard I try I won’t succeed on the test.';
$string['test-related-hopelessness-6'] = 'I start to realize that the questions are much too difficult for me.';
$string['test-related-hopelessness-7'] = 'I feel so resigned about the exam that I can’t start doing anything.';
$string['test-related-hopelessness-8'] = 'I’d rather not write the test because I have lost all hope.';
$string['test-related-hopelessness-9'] = 'I feel like giving up.';
$string['test-related-hopelessness-10'] = 'My hopelessness robs me of all my energy.';
$string['test-related-hopelessness-11'] = 'I feel so resigned that I have no energy.';
