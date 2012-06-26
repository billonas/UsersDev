<?php
// View:
$this->PhpExcel->createWorksheet();
$this->PhpExcel->setDefaultFont('Calibri', 12);
// define table cells
$table = array(
    array('label' => __('Φωτογραφία'), 'width' => 'auto', 'filter' => true),
    array('label' => __('created'), 'width' => 'auto', 'filter' => true),
    array('label' => __('Date'), 'width' => 'auto'),
    array('label' => __('exif'), 'width' => 50, 'wrap' => true),
    array('label' => __('scientific_name'), 'width' => 'auto')
);

// heading
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true, 'offset' => 0));
// data
foreach ($data as $d) {
    $this->PhpExcel->addTableRow(array(
        $d['Report']['created'],
        $d['Report']['date'],
        $d['Report']['exif'],
        $d['Specie']['scientific_name']
    ), $d['Report']['main_photo']);
}
$this->PhpExcel->addTableFooter();
$this->PhpExcel->output();
?>
