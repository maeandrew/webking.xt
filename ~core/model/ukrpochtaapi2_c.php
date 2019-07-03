<?php
/**
 *    module: Ukrpochta 0.0.1
 *    author: VP
 *    version: 1.0
 *    create: 12.06.2019
 **/
// namespace Ukrpochta;
class UkrPochtaApi2{
    private $version = '0.0.1/';
    private $api = 'https://www.ukrposhta.ua/ecom/';
    //основные
    // private $key = array(
    //     'BEARER' => '4c8b3710-813c-36a4-97fc-3a9a6252d163',
    //     'BEARER_ST' => 'f9354925-fd61-3921-8e40-0df6f289871e',
    //     'TOKEN' => '93cb30d5-5adc-41c0-bfb4-fb70613451c8',
    //     'UUID' => 'd0830571-0b16-49a5-9d99-48f08454e1e7');
    //тестовые
    private $key = array(
        'BEARER' => '5460e086-2598-3deb-a6cb-d72b8225517b',
        'BEARER_ST' => 'bc9ee71d-8ae3-3d21-8482-5f0eb90b69df',
        'TOKEN' => '96891f96-a480-48d1-90e3-7e3f38b1a142',
        'UUID' => 'd0830571-0b16-49a5-9d99-48f08454e1e7');

    public function __construct(){
    }
    public function __destruct(){
    }
    //url доступа к API
    private function url($url){

        return $url;
    }
    //подготока даных
    // private function prepare($data){
    //     return json_encode($data, JSON_UNESCAPED_UNICODE);
    // }
    //header доступа к API
    private function header(){
        $header = array(
         "Content-Type:application/json",
         "Authorization:Bearer ".$this->key['BEARER']
        );
        return $header;
    }
    //post доступа к API
    public function post($url, $body){
        if($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header());
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
            curl_exec($curl);
            $result = json_decode(curl_exec($curl));
            curl_close($curl);      
          }else {
                $result = file_get_contents($url, null, stream_context_create(array(
                    'http' => array(
                        'method' => 'POST',
                        'header' => "Content-Type:application/json;",
                        'content' => $body,
                     ),
                ))); 
             }
          return $result;
    }
    //get доступа к API
    public function get($url){
        if($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header());
            $result = json_decode(curl_exec($curl));
            curl_close($curl);      
          }else {
                $result = file_get_contents($url, null, stream_context_create(array(
                    'http' => array(
                        'method' => 'get',
                        'header' => "Content-Type:application/json;\r\n",
                        'content' => '',
                     ),
                ))); 
             }
        return $result;
    }
    public function put($url, $body){
        if($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header());
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");     
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
            // echo curl_exec($curl);
            $result = json_decode(curl_exec($curl));
            curl_close($curl);      
          }else {
                $result = file_get_contents($url, null, stream_context_create(array(
                    'http' => array(
                        'method' => 'PUT',
                        'header' => "Content-Type:application/json;\r\n",
                        'content' => $body,
                     ),
                ))); 
             }
          return $result;
    }
    public function delete($url){
        if($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header());
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            $httpCode = curl_getinfo($curl);
            // echo curl_exec($curl);
            $result = curl_exec($curl);
            curl_close($curl);      
          }else {
                $result = file_get_contents($url, null, stream_context_create(array(
                    'http' => array(
                        'method' => 'DELETE',
                        'header' => "Content-Type:application/json;\r\n",
                        'content' => $body,
                     ),
                ))); 
             }
          return $result;
    }

    //Создать адрес
    public function createAddress($body){
        $url = $this->url($this->api.$this->version.'addresses');
       return $this->post($url, $body);
    } 
    //Показать адрес по ID
    public function getAddress($id){
        $url = $this->url($this->api.$this->version.'addresses/'.$id);
       return $this->get($url);
    }
   
    // Создаем клиента
    public function createClient($body){
        $url = $this->url($this->api.$this->version.'clients?token='.$this->key['TOKEN']);
       return $this->post($url, $body);
    }
    //Редактируем клиента
      public function editClient($client){
        $body = array(
                 'name'=>$client->name,
                 'addressId'=>$client->addressId,
                 'phoneNumber'=>$client->phoneNumber
                );        
        $url = $this->url($this->api.$this->version.'clients/'.$client->uuid.'?token='.$this->key['TOKEN']);
       return $this->put($url, $body);
    }
      // Изменить адрес у клиента
    public function editAddress($client, $addressId){
        $body = array(
                'addresses'=>array(
                    'addressId'=>array($addressId),
                    'main'=>true
                ),
                array(
                    'addressId'=>array($addressId)
                )
            ); 
        $url = $this->url($this->api.$this->version.'clients/'.$client->uuid.'?token='.$this->key['TOKEN']);

    echo $addressId, '<br/>';        
    print_r('<pre>');
    print_r(json_encode($body));
    print_r('</pre>');    
    echo $url, "<br/>";
       return $this->put($url, $body);
    }
    //Удаление клиентов
    public function clientsDelete($id){
        $url = $this->url($this->api.$this->version.'clients/'.$id.'?token='.$this->key['TOKEN']);
        return $this->delete($url);
    }
    //видалення телефонного номера клієнта
    public function clientPhonesDelete($id){
        $url = $this->url($this->api.$this->version.'client-phones/'.$id.'?token='.$this->key['TOKEN']);
        return $this->delete($url);
    }
    //отримання створених клієнтів за externalId
    public function getСlientsExternalId($externalId){
        $url = $this->url($this->api.$this->version.'clients/externalid/'.$externalId.'?token='.$this->key['TOKEN']);
        return $this->get($url);
    }
    
    /*отримання створених клієнтів за телефонним номером
    *$phoneNumber 
    *return - масив клиентов
    */
    public function getСlientsPhoneNumber($phoneNumber){
        $url = $this->url($this->api.$this->version.'clients/phone?token='.$this->key['TOKEN'].'&countryISO3166=UA&phoneNumber='.$phoneNumber);
        return $this->get($url);
    }







    //Список клиентов
    public function clientsList($token)
    {
        return $this->requestData('clients', '', '/?token=' . $token, 'get');
    }
    //Показать клиента по ID
    public function getClient($token, $id = '', $extID = '', $type = true)
    {
        if ($type) {

            return $this->requestData('clients', '', $id . '?token=' . $token, 'get');

        } else {

            return $this->requestData('clients', '', 'external-id/' . $extID . '?token=' . $token, 'get');

        }
    }
    //Создать группу отправок
    public function createGroup($token, $data = array())
    {
        return $this->requestData('shipment-groups?token=' . $token, $data);
    }
    //Редактировать группу отправок
    public function editGroup($token, $id, $data = array())
    {
        return $this->requestData('shipment-groups', $data, $id . '?token=' . $token, 'put');
    }

     // ПОЛУЧИТЬ СПИСОК ОТПРАВЛЕНИЙ
     public function groupList($token)
    {
        return $this->requestData('shipment-groups?token=' . $token, '', '', 'get');
    }

     //  ПОКАЗАТЬ ГРУППУ ОТПРАВЛЕНИЙ ПО ID
     public function getGroup($id, $token)
    {
        return $this->requestData('shipment-groups', '', $id . '?token=' . $token, 'get');
    }

     //  СОЗДАТЬ НОВУЮ ПОСЫЛКУ
     public function createParcel($token, $data = array())
    {
        return $this->requestData('shipments?token=' . $token, $data);
    }

     //  РЕДАКТИРОВАНИЕ ПОЧТОВОЕ ОТПРАВЛЕНИЕ
     public function editParcel($id, $token, $data = array())
    {
        return $this->requestData('shipments', $data, $id . '?token=' . $token, 'put');
    }
     //  ПОКАЗАТЬ СПИСОК ПОЧТОВЫХ ОТПРАВЛЕННИЙ
     public function parcelList($token)
    {
        return $this->requestData('shipments?token=' . $token, '', '', 'get');
    }

     //  ПОКАЗАТЬ ПОЧТОВОЕ ОТПРАВЛЕНИЕ ПО ID
     public function getParcel($id, $token, $type = true)
    {
        if ($type) {

            return $this->requestData('shipments', '', $id . '?token=' . $token, 'get');

        } else {

            return $this->requestData('shipments', '', '?senderuuid=' . $id . '&token=' . $token, 'get');

        }

    }

     //  УДАЛЕНИЯ ПОЧТОВОГО ОТПРАВЛЕНИЯ С ГРУППЫ
    public function delParcelGroup($id, $token)
    {
        return $this->requestData('shipments', '', $id . '/shipment-group?token=' . $token, 'delete');
    }

     //  СОЗДАТЬ ФОРМУ В PDF ФОРМАТЕ
     public function createForm($id, $token, $path, $type = true)
    {
        if ($type) {

            $pdf = $this->requestData('shipments', '', $id . '/form?token=' . $token, 'get');

        } else {

            $pdf = $this->requestData('shipment-groups', '', $id . '/form?token=' . $token, 'get');

        }
        if ($this->error($pdf)) {
            $this->savePDF($pdf, $path);
        }
    }

     //  СОЗДАТЬ ФОРМУ 103 В PDF ФОРМАТЕ
    public function createForm103($id, $token, $path)
    {
        $pdf = $this->requestData('shipment-groups', '', $id . '/form103?token=' . $token, 'get');

        if ($this->error($pdf)) {
            $this->savePDF($pdf, $path);
        }
    }

     // СОХРАНЯЕМ PDF ФАЙЛ
     private function savePDF($pdf, $path)
    {
        file_put_contents($path, $pdf);
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($path) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($path));
        header('Accept-Ranges: bytes');
        readfile($path);
    }

     //  ПРОВЕРКА НА ОШИБКУ
     private function error($content)
    {
        $content = json_decode($content, true);
        if (isset($content['message'])) {
            print_r($content);
            return false;
        }
        return true;
    }






    // Адресный справочник
    public function GETukrpochta($array){
        $key =  $array['key']?$array['key']:'';                                                     //ключ функции
        $region_name = isset($array['region_name'])?$array['region_name']:'';                       // найменування області
        $region_name_en = isset($array['region_name_en'])?$array['region_name_en']:'';              // найменування області англійською
        $region_id = isset($array['region_id'])?$array['region_id']:'';                             // ідентифікатор області
        $district_ua = isset($array['district_ua'])?$array['district_ua']:'';                       // найменування района
        $district_id = isset($array['district_id'])?$array['district_id']:'';                       // ідентифікатор района
        $city_ua = isset($array['city_ua'])?$array['city_ua']:'';                                   // АвOwnOf – сільрада, до якої належить
        $city_id= isset($array['city_id'])?$array['city_id']:'';                                    // ідентифікатор населеного пункта
        $street_ua = isset($array['street_ua'])?$array['street_ua']:'';                             // найменування вулиці
        $street_id = isset($array['street_id'])?$array['street_id']:'';                             // ідентифікатор вулиці
        $housenumber = isset($array['housenumber'])?$array['housenumber']:'';                       // номер будинку
        $pi = isset($array['pi'])?$array['pi']:'';                                                  // поштовий індекс
        $id = isset($array['id'])?$array['id']:'';                                                  // ідентифікатор поштового відділення
        $lat = isset($array['lat'])?$array['lat']:'';                                               // географічна широта
        $long = isset($array['long'])?$array['long']:'';                                            // географічна довгота
        $maxdistance = isset($array['maxdistance'])?$array['maxdistance']:'';                       // радіус пошуку поштового відділення в км
        $lang = isset($array['lang'])?$array['lang']:'ru';                                          // ідентифікатор обраної мови (EN, RU, UA)
        $district_name = isset($array['district_name'])?$array['district_name']:'';                 // назва району (або її частина, якщо fuzzy = 1)
        $pc = isset($array['pc'])?$array['pc']:'';                                                  // поштовий код (мінімум 3 перші цифри)
        $postcode = isset($array['postcode'])?$array['postcode']:'';                                // поштовий код (мінімум 5 цифр)
        $fuzzy = isset($array['fuzzy'])?$array['fuzzy']:'';                                         // відповідає за включення функції нечіткого пошуку
        $city_name = isset($array['city_name'])?$array['city_name']:'';                             // назва міста (або її частина, якщо fuzzy = 1)
        $street_name = isset($array['street_name'])?$array['street_name']:'';                       // назва вулиці (або її частина, якщо fuzzy = 1)

        $get_array = array(
            // ПЕРЕЛІКУ ОБЛАСТЕЙ (З МОЖЛИВІСТЮ ПОШУКУ ЗА ЧАСТИНОЮ НАЗВИ)
            1 =>    'https://ukrposhta.ua/address-classifier/get_regions_by_region_ua?region_name='.urlencode($region_name).'&region_name_en='.urlencode($region_name_en),
            //ПЕРЕЛІКУ РАЙОНІВ
            2 =>    'https://ukrposhta.ua/address-classifier/get_districts_by_region_id_and_district_ua?region_id='.urlencode($region_id).'&district_ua='.urlencode($district_ua),
            //ПЕРЕЛІКУ НАСЕЛЕНИХ ПУНКТІВ
            3 =>    'https://ukrposhta.ua/address-classifier/get_city_by_region_id_and_district_id_and_city_ua?district_id='.urlencode($district_id).'&region_id='.urlencode($region_id).'&city_ua='.urlencode($city_ua),
            //ПЕРЕЛІКУ ВУЛИЦЬ
            4 =>    'https://ukrposhta.ua/address-classifier/get_street_by_region_id_and_district_id_and_city_id_and_street_ua?region_id='.urlencode($region_id).'&district_id='.urlencode($district_id).'&city_id='.urlencode($city_id).'&street_ua='.urlencode($street_ua),
            //ПЕРЕЛІКУ БУДИНКІВ ВУЛИЦЬ
            5 =>    'https://ukrposhta.ua/address-classifier/get_addr_house_by_street_id?street_id='.urlencode($street_id).'&housenumber='.urlencode($housenumber),
            //ІНФОРМАЦІЇ ПРО ПОШТОВЕ ВІДДІЛЕННЯ
            6 =>    'https://ukrposhta.ua/address-classifier/get_postoffices_by_postindex?pi='.urlencode($pi),
            //ІНФОРМАЦІЇ ПРО ГРАФІК РОБОТИ ПОШТОВОГО ВІДДІЛЕННЯ
            7 =>    'https://ukrposhta.ua/address-classifier/get_postoffices_openhours_by_postindex?pc='.urlencode($pc).'&id='.urlencode($pi),
            //ІНФОРМАЦІЇ ПРО НАЙБЛИЖЧІ ПОШТОВІ ВІДДІЛЕННЯ
            8 =>    'https://ukrposhta.ua/address-classifier/get_postoffices_by_geolocation?lat='.urlencode($lat).'&long='.urlencode($long).'&maxdistance='.urlencode($maxdistance),
            //ІНФОРМАЦІЇ ПРО ПОШТОВІ ВІДДІЛЕННЯ МІСТА
            9 =>    'https://ukrposhta.ua/address-classifier/get_postoffices_by_city_id?city_id='.urlencode($city_id).'&district_id='.urlencode($lat).'&region_id='.urlencode($region_id),
            //ІНФОРМАЦІЇ ПРО ОБЛАСТЬ, РАЙОН І НАСЕЛЕНИЙ ПУНКТ ЗА ІНДЕКСОМ
            10 =>   'https://ukrposhta.ua/address-classifier-ws-pub/get_city_details_by_postcode?postcode='.urlencode($postcode).'&lang='.urlencode($lang),
            //АДРЕСНОЇ ІНФОРМАЦІЇ ЗА ІНДЕКСОМ
            11 =>   'https://ukrposhta.ua/address-classifier/get_address_by_postcode?postcode='.urlencode($postcode).'&lang='.urlencode($lang),
            //ОТРИМАННЯ РАЙОНУ ЗА НАЗВОЮ
            12 =>   'https://ukrposhta.ua/address-classifier/get_district_by_name?region_id='.urlencode($region_id).'&district_name='.urlencode($district_name).'&lang='.urlencode($lang).'&fuzzy='.urlencode($fuzzy),
            //МІСТА ЗА НАЗВОЮ
            13 =>   'https://ukrposhta.ua/address-classifier/get_city_by_name?region_id='.urlencode($region_id).'&district_id='.urlencode($district_id).'&city_name='.urlencode($city_name).'&lang='.urlencode($lang).'&fuzzy='.urlencode($fuzzy),
            //ОТРИМАННЯ ВУЛИЦІ ЗА НАЗВОЮ
            14 =>   'https://ukrposhta.ua/address-classifier/get_street_by_name?city_id='.urlencode($city_id).'&street_name='.urlencode($street_namet).'&lang='.urlencode($lang).'&fuzzy='.urlencode($fuzzy));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $get_array[$key]);
        if (!$get_parsed = simplexml_load_string(curl_exec($ch))){
            echo "Не удалось получить список<br/>";
        }
        curl_close($ch);
        return $get_parsed;
    }   
}
