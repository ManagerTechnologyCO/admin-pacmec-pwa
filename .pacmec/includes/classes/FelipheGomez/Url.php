<?php

namespace FelipheGomez;

class Url{
	/** Crea etiqueta Url
	 * @param[0] string URL Simple => (nombre del controlador / nombre de la accion)
	 * @param[1] array param1
	 * @param[2] array param2
	 * @return string
	 */
	public static function to($params = array()){
		$controller = CONTROLADOR_DEFECTO;
		$action = ACCION_DEFECTO;
		$query = "";
		if(is_array($params) && isset($params[0])){
			$url = explode('/', $params[0]);
			$controller = isset($url[0]) ? $url[0] : CONTROLADOR_DEFECTO;
			$action = isset($url[1]) ? $url[1] : ACCION_DEFECTO;
			unset($params[0]);
			foreach($params as $item){
				foreach($item as $k=>$v){
					$query .= "&".urlencode($k)."=".urlencode($v);
				}
			}
		}else{
			if(is_string($params)){
				return $params;
			}
		}
		$url = linkRoute($controller, $action);
		return $url . $query;
	}
	
	/** Crea etiqueta a
	 * @param string $tag_name nombre de la etiqueta (por ej. div)
	 * @param string $content contenido de la etiqueta
	 * @param array $estilos estilos de la etiqueta, por defecto array vacio
	 * @param array $attributes array asociativo con elementos y su valor, por ejemplo array('id' => 'mi-tag')
	 * @return string
	 */
	public static function a($url = array(), $content, $styles = array(), $attributes = array()){
		$attributes_str = "";
		$attributes['href'] = Url::to($url);
		foreach ($attributes as $key => $val) {
			$attributes_str .= ' ' . ($key) . '="' . $val . '"';
		}
		return '<a' . Url::tag_class($styles) . urldecode($attributes_str) . '>' . $content . '</a>' . "\n";
	}

	/** 
	 * @param array $estilos
	 * @return string con el class de una etiqueta (o un string vacio si no hay estilos)
	 */
	private static function tag_class($styles = array()){
		if(!is_array($styles)){
			$styles = array($styles);
		}
		return (!empty($styles)) ? ' class="' . implode(" ", $styles) . '"' : "";
	}
	
	public static function ul($contents = array(), $styles = array()){
		$content = "<li>" . implode("</li>\n<li>", $contents) . "</li>";
		return Url::tag('ul', $content, $styles);
	}
	
	/** Crea etiqueta html
	 * @param string $tag_name nombre de la etiqueta (por ej. div)
	 * @param string $content contenido de la etiqueta
	 * @param array $estilos estilos de la etiqueta, por defecto array vacio
	 * @param array $attributes array asociativo con elementos y su valor, por ejemplo array('id' => 'mi-tag')
	 * @return string
	 */
	public static function tag($tag_name, $content, $styles = array(), $attributes = array()){
		$attributes_str = "";
		foreach ($attributes as $key => $val) {
			$attributes_str .= ' ' . $key . '="' . $val . '"';
		}
		return '<' . $tag_name . Html::tag_class($styles) . $attributes_str . '>' . $content . '</' . $tag_name . '>' . "\n";
	}

	
}

?>