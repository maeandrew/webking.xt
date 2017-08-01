<?php
class Tpl {
	protected $data = null;
	protected $global = null;
	/**
	 * Конструктор класса
	 * @return ничего
	 */
	public function __construct() {
		$this->data = array();
	}
	/**
	 * Генерирует HTML на основе файла шаблона.
	 * @param string $pTemplateName Полное имя файла шаблона.
	 * @return string Возвращает HTML.
	 */
	public function Parse($pTemplateName){
		//echo $pTemplateName."<br>";
		if(is_file($pTemplateName) && is_readable($pTemplateName)){
			foreach($this->data as $key=>$value) {
				$$key = $value;
			}
			if(!empty($this->global)){
				foreach($this->global as $key){
					global $$key;
				}
			}
			ob_start();
			require($pTemplateName);
			$w_res = ob_get_clean();
			return $w_res;
		}else{
			return '<br>Template error. File <b>'.$pTemplateName.'</b> in '.__FILE__.' in line '.__LINE__.'<br>';
		}
	}
	/**
	 * Определяет переменную шаблона
	 * @param string $pKey Имя переменной.
	 * @param $pObject Значение переменной.
	 * @return ничего
	 */
	public function Assign($pKey, $pObject) {
		$this->data[$pKey] = $pObject;
	}
	/**
	 * Определяет переменную шаблона для определения ее из глобальной
	 * @param string $pKey Имя переменной.
	 * @param $pObject Значение переменной.
	 * @return ничего
	 */
	public function AssignGlobal($pArr) {
		$this->global = $pArr;
	}
	/**
	 * Удаляет все ранее определенные переменные шаблона.
	 * @return ничего
	 */
	public function Clear() {
		$this->data = array();
		$this->global = array();
	}
}
?>