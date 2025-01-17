<?php

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

$string['coleta_limitada_aviso'] = 'The collection started on {$a->datainicio}. Some changes are limited. For more details about this collection, return to the <a href="{$a->listagemurl}">list</a>.';
$string['coleta_atualizada_com_sucesso'] = 'The collection was successfully updated.';
$string['returntolist'] = 'Return to the list';

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

// Welcome message
$string['welcome'] = 'Welcome to StudentCare!';

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

//Perguntas learning related
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


//Perguntas test related
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

?>