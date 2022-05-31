<?php

namespace isrdxv\practice\translation;

use isrdxv\practice\translation\TranslationException;
use pocketmine\utils\TextFormat;

use isrdxv\practice\Loader;

class Translation
{
  
  public function getLanguageByNumber(int $number): string
  {
    switch($number){
    case 0:
      $language = "es_ES";
    break;
    case 1:
      $language = "es_MX";
    break;
    case 2:
      $language = "en_US";
    break;
    /*default: 
      $language = "en_US";
    break;*/
    }
    return $language;
  }
  
  public function getNumberByLanguage(string $language): int
  {
    switch($language){
    case "es_ES":
      $language = 0;
    break;
    case "es_MX":
      $language = 1;
    break;
    case "en_US":
      $language = 2;
    break;
    }
    return $language;
  }
  
  public function addMessage(string $language, string $message, array $args = null): string
  {
    if ($language === null && $message === null) {
      throw new LanguageException("[Practice: Translation] el mensaje no puede estar vacio, y el lenguaje tampoco");
    }
    if (!is_file(Loader::getInstance()->getDataFolder() . "languages" . DIRECTORY_SEPARATOR . $language . ".ini")) {
      throw new LanguageException("[Practice: Translation] Lo siento, no hay un archivo con ese lenguaje, este mensaje es para que agrege el archivo de este lenguaje");
    }
    $messages = parse_ini_file(Loader::getInstance()->getDataFolder() . "languages" . DIRECTORY_SEPARATOR . (($language === "es_MX") ? "es_ES" : $language) . ".ini");
    if ($args !== null) {
      foreach($args as $arg => $data) {
        $text = str_replace($arg, $data, $messages[$message]);
      }
    }
    return ($args === null) ? $messages[$message] : $text;
  }
  
}
