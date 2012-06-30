<?php
// View:
$this->PhpExcel->createWorksheet();
$this->PhpExcel->setDefaultFont('Calibri', 12);
// define table cells
$table = array(
    array('label' => __('Φωτογραφία'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Παραχώρηση Χρήσης Πολυμέσων'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Είδος στόχος'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Βάθος'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Πλήθος ατόμων'), 'width' => 'auto'),
    array('label' => __('Το έχετε ξανδεί;'), 'width' => 50, 'wrap' => true),
    array('label' => __('Ημ/νία Παρατήρησης'), 'width' => 'auto'),
    array('label' => __('Ημ/νία exif'), 'width' => 'auto'),
    array('label' => __('Τοποθεσία(χ συντ)'), 'width' => 'auto'),
    array('label' => __('Τοποθεσία(ψ συντ)'), 'width' => 'auto'),
    array('label' => __('Περιοχή'), 'width' => 'auto'),
    array('label' => __('Βιότοπος'), 'width' => 'auto'),
    array('label' => __('Σχόλια Παρατηρητή'), 'width' => 'auto'),
    array('label' => __('ημερομηνία γέννησης'), 'width' => 'auto'),
    array('label' => __('εκπαίδευση'), 'width' => 'auto'),
    array('label' => __('Ιδιότητα'), 'width' => 'auto'),
    array('label' => __('Όνομα'), 'width' => 'auto'),
    array('label' => __('Επώνυμο'), 'width' => 'auto'),
    array('label' => __('Ψευδώνυμο'), 'width' => 'auto'),
    array('label' => __('τηλέφωνο'), 'width' => 'auto'),
array('label' => __('διεύθυνση ηλ. ταχ.'), 'width' => 'auto'),
array('label' => __('Πόλη'), 'width' => 'auto'),
array('label' => __('Διεύθυνση'), 'width' => 'auto'),
array('label' => __('Χώρα'), 'width' => 'auto'),
array('label' => __('Κατηγορία'), 'width' => 'auto'),
array('label' => __('Επιστημονική ονομασία'), 'width' => 'auto'),
array('label' => __('Σχόλια αναλυτή'), 'width' => 'auto'),
array('label' => __('Κατάσταση'), 'width' => 'auto'),
array('label' => __('Αξιολόγηση(βαθμολογία)'), 'width' => 'auto'),
array('label' => __('Επεξεργάστηκε από'), 'width' => 'auto'),
array('label' => __('Δημιουργία'), 'width' => 'auto'),
array('label' => __('Τροποποίηση'), 'width' => 'auto'),
);

// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true, 'offset' => 0));
// data
foreach ($data as $d) {
if($d['Report']['observer'] == null){
    $this->PhpExcel->addTableRow(array(
        $d['Report']['permissionUseMedia'],
        $d['Report']['hot_species'],
        $d['Report']['depth'],
        $d['Report']['crowd'],
$d['Report']['re_observation'],
$d['Report']['date'],
$d['Report']['exif'],
$d['Report']['lat'],
$d['Report']['lng'],
$d['Report']['area'],
$d['Report']['habitat'],
$d['Report']['comments'],
$d['Report']['age'],
$d['Report']['education'],
$d['Report']['occupation'],
$d['Report']['name'],
$d['Report']['surname'],
"",
$d['Report']['phone_number'],
$d['Report']['email'],
"",
"",
"",
$d['Category']['category_name'],
$d['Specie']['scientific_name'],
$d['Report']['analyst_comments'],
$d['Report']['state'],
$d['Report']['voting'],
$d['Last_edited_by']['name'],
$d['Report']['created'],
$d['Report']['modified']
    ), $d['Report']['main_photo']);
}
else{
$this->PhpExcel->addTableRow(array(
        $d['Report']['permissionUseMedia'],
        $d['Report']['hot_species'],
        $d['Report']['depth'],
        $d['Report']['crowd'],
$d['Report']['re_observation'],
$d['Report']['date'],
$d['Report']['exif'],
$d['Report']['lat'],
$d['Report']['lng'],
$d['Report']['area'],
$d['Report']['habitat'],
$d['Report']['comments'],
$d['User']['birth_date'],
$d['User']['education'],
$d['User']['membership'],
$d['User']['name'],
$d['User']['surname'],
$d['User']['username'],
$d['User']['phone_number'],
$d['User']['email'],
$d['User']['city'],
$d['User']['address'],
$d['User']['country'],
$d['Category']['category_name'],
$d['Specie']['scientific_name'],
$d['Report']['analyst_comments'],
$d['Report']['state'],
$d['Report']['voting'],
$d['Last_edited_by']['name'],
$d['Report']['created'],
$d['Report']['modified']
    ), $d['Report']['main_photo']);
}
}
$this->PhpExcel->addTableFooter();
$this->PhpExcel->output();
?>
