<?php
class sdescr {
	private $seed; 
	private $entity_name; 
	private $parts;
	private $linked_pages; // array('url','anchor')
	private $descr;
	
	/**
	 * 
	 * @param string $entity_name Имя материала, например название товара
	 * @param int $seed Уникальное число, например идентификатор товара
	 */
	
	public function __construct($entity_name = null, $seed = null){
		$this->entity_name = $entity_name;
		$this->seed = $seed;
	}
	
	/**
	 *  @param string $descr
	 */
	
	public function setDescr($descr)
	{
		$this->descr = $descr;
	}

	/**
	 * @return string СЕО Описание
	 */
	
	public function getDescr()
	{
		$descr=$this->combine($this->parts);
		$descr = $this->insertBacklinks($descr);
		$descr = $this->insertEntityName($descr);
		$this->setDescr($descr);
		
		return $this->descr;
	}
	
	/**
	 * @param string $path
	 */
	
	public function setParts($parts)
	{
		$this->parts = $parts;
	}
	
	/**
	 * @param string $path
	 */
	
	public function setLinkedPages($linked_pages)
	{
		$this->linked_pages = $linked_pages;
	}
	
	/**
	 * @param array $array
	 */
	
	private function combine($array)
	{
		$descr = null;
		
		foreach ($array as $passage)
		{
			if(is_array($passage))$descr .= $this->pick($passage);
			else $descr .= $passage." ";
		}
		
		return $descr;
	}
	
	/**
	 * @param array $array
	 */
	
	private function pick($array)
	{
		$size = count($array);
		$index = $this->seed % $size;
				
		if(!is_array($array[$index])) return $array[$index] . " ";
		else return $this->pick($array[$index]);	
			
	}
	
	/**
	 * Заменяет вхождения ключевых слов ссылками
	 */
	
	private function insertBacklinks($descr)
	{
		foreach($this->linked_pages as $link)
		{
			$a = "<a href='http://".$link['url']."' title='".$link['title']."'>".$link['anchor']."</a>";
			$descr=str_replace($link['anchor'], $a, $descr);
		}
		
		return $descr;
	}
	
	/**
	 * Вставляет название материала в описание
	 */
	private function insertEntityName($descr, $placeholder="%entity_name%")
	{
			$descr=str_replace($placeholder, $this->entity_name, $descr);
			return $descr;
	}
	
	
		
}