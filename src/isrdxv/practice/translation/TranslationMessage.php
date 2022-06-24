<?php

namespace isrdxv\practice\translation;

use isrdxv\practice\translation\TranslationException;

final class TranslationMessage
{
  /** @var String **/
  private $text;
  /** @var Array **/
  private $params = [];
  
  public function __construct(string $text = "", array $params = null)
  {
    if (empty($text)) {
      throw new TranslationException("$text variable is null or empty string");
    }
    if ($params === []) {
      throw new TranslationException("The variable $params is an empty array");
    }
    $this->text = $text;
    $this->params = $params ?? null;
  }
  
  public function getText(): string
  {
    return $this->text;
  }
  
  /** 
   * @return mixed[]
   */
  public function getParameters(): array
  {
    return $this->params;
  }
  
  public function getParameter(string $key): ?string
  {
    return $this->params[$key] ?? null;
  }
  
}
