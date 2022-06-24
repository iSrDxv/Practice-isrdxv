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
    if (empty($language) && empty($message)) {
      throw new LanguageException("[Practice: Translation] the message cannot be empty, and neither can the language");
    }
    if (!is_file(Loader::getInstance()->getDataFolder() . "languages" . DIRECTORY_SEPARATOR . $language . ".ini")) {
      throw new LanguageException("[Practice: Translation] Sorry, there is no file with that language, this message is for you to add the file of this language");
    }
    $messages = parse_ini_file(Loader::getInstance()->getDataFolder() . "languages" . DIRECTORY_SEPARATOR . $language . ".ini");
    if (!isset($messages[$message])) {
      throw new TranslationException("The message i add does not exist in the language folders")
    }
    $message = $messages[$message];
    if (is_array($args)) {
      foreach($args as $arg => $data) {
        $message = str_replace("%" . $arg . "%", $data, $message);
      }
    }
    return $message;
  }
  
}