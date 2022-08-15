<?php
ini_set('max_execution_time', 0);

require 'vendor/autoload.php';
require 'classes/DataSpreadsheet.class.php';
require 'classes/Database.class.php';
require 'config.php';

// Import the core class of PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if( empty( $_FILES['xml']['name'] ) ){
    echo json_encode(['status' => false, 'message' => 'Falha no processamento.']);
    exit;
}

$conn = new Database();
$xml = simplexml_load_file($_FILES['xml']['tmp_name']);

$data = [];
$array = [];
$array_data = [];
foreach($xml->torcedor as $key => $xml){
    array_push($data, $xml);
}
$data = (array) $data;

for($x=0; $x < count($data); $x++){
    $array['nome'] = (string) $data[$x]['nome'];
    $array['documento'] = (string) $data[$x]['documento'];
    $array['cep'] = (string) $data[$x]['cep'];
    $array['endereco'] = (string) $data[$x]['endereco'];
    $array['bairro'] = (string) $data[$x]['bairro'];
    $array['cidade'] = (string) $data[$x]['cidade'];
    $array['uf'] = (string) $data[$x]['uf'];
    $array['telefone'] = (string) $data[$x]['telefone'];
    $array['email'] = (string) $data[$x]['email'];
    $array['ativo'] = (string) $data[$x]['ativo'];
    array_push($array_data, $array);
}

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load( FILENAME );
$spread = new DataSpreadsheet( $spreadsheet );

try{
    for($i = 0; $i < count( $array_data ); $i++){
    
        $next = $spread->get_last_row(); //current line to add in spreadsheet
        $spread->add_new_data_spreadsheet( $array_data[ $i ], $next );
        $conn->db_insert_clients( $array_data[$i] ); // insert into database
        
    }
    echo json_encode(['status' => true, 'message' => 'Clientes atualizado com sucesso.']);
}
catch(Exception $e){
    echo json_encode(['status' => false, 'message' => 'Falha no processamento.']);
}


