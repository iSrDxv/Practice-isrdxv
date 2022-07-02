<?php

namespace isrdxv\practice\webhook;

use libs\discord\Webhook;

use isrdxv\practice\Loader;

class WebhookManager
{
  private Webhook $user;
  
  private Webhook $staff;
  
  public function __construct(Loader $loader)
  {
    $this->user = new Webhook($loader->getConfig()->get("discord-logs")["user"]["url"]);
    $this->staff = new Webhook($loader->getConfig()->get("discord-logs")["staff"]["url"]);
  }
  
  public function getWebhookUser(): Webhook
  {
    return $this->user;
  }
  
  public function getWebhookStaff(): Webhook
  {
    return $this->staff;
  }
  
}