<?php
declare(strict_types=1);

namespace libs\cache;

class Cache
{
  private array $data = [];
  
  public function set(string $box, ...$values): void
  {
    if (isset($this->data[$box])) {
      if (is_array($values)) {
        foreach($values as $data => $value) {
        $this->data[$box][$data] = $value;
        return;
        }
      }
    }
    $this->data[$box] = $values;
  }
  
  public function get(string $box, &$value): mixed
  {
    return $this->data[$box][$value];
  }
  
}