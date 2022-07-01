<?php

namespace isrdxv\practice\form;

use pocketmine\utils\SingletonTrait;
use pocketmine\Server;
use pocketmine\player\Player;

use libs\formapi\{
  BaseForm,
  MenuForm,
  MenuOption,
  CustomForm,
  CustomFormResponse,
  ModalForm,
  element\Label,
  element\Input,
  element\Dropdown,
  element\Toggle
};

use isrdxv\practice\{
  Loader,
  session\Session,
  session\SessionManager,
  queue\QueueManager,
  translation\Translation
};

class FormManager
{
  use SingletonTrait;
  
  public function settings(Session $session): CustomForm
  {
    return new CustomForm(
      Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-title-form"),
      [
        new Label("text", Loader::getinstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-text-form")),
        new Dropdown("language", Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-language-form"), [
          "es_ES",
          "es_MX",
          "en_US"
        ], Loader::getInstance()->getTranslation()->getNumberByLanguage($session->getLanguage())),
        new Toggle("cps", Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-cps-form"), $session->getSetting("cps")),
        new Toggle("score", Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-scoreboard-form"), $session->getSetting("score")),
        new Toggle("queue", Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-queue-form"), $session->getSetting("queue")),
        new Toggle("auto-join", Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-join-form"), $session->getSetting("auto-join"))
      ],
      function(Player $player, CustomFormResponse $response): void {
        Loader::getInstance()->getProvider()->setLanguage($player->getName(), Loader::getInstance()->getTranslation()->getLanguageByNumber($response->getInt("language")));
        Loader::getInstance()->getProvider()->saveSettings($player->getName(), [
          "cps" => $response->getBool("cps"), 
          "score" => $response->getBool("score"),
          "queue" => $response->getBool("queue"),
          "auto-join" => $response->getBool("auto-join")
          ]);
        $player->sendMessage("");
      }
    );
  }
  
  public function party(Session $session): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "party-title-form"),
      Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "party-text-form"),
      [
        new MenuOption(Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "party-create-form")),
        new MenuOption(Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "party-invite-form")),
        new MenuOption(Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "party-public-form"))
      ],
      function(Player $player, int $selectedOption): void {
        switch($selectedOption){
          case 0:
            $player->sendMessage("coming soon...");
          break;
          case 1:
            $player->sendMessage("coming soon...");
          break;
          case 2:
            $player->sendMessage("coming soon...");
          break;
        }
      }
    );
  }
  
  public function arena(Player $player): CustomForm
  {
    return new CustomForm("Arena Creator", "create the arenas for practice c:", 
    [
      new Input("arena_name", "Name from Arena", "world"),
      new Dropdown("arena_slots", "Slots for the Arena", [
        "2",
        "4",
        "6"
      ]),
      new Input("arena_mode", "Mode for your Arena", "nodebuff"),
      new Input("arena_type", "Mode for your Arena", "solo"),
      new Toggle("arena_ranked", "Classified Arena or not?", false),
      new Dropdown("arena_type_mode", "Mode Type for Your Server", ["Duel", "FFA"])
    ],
    function(Player $player, CustomFormResponse $response): void {
      $arena_name = $response->getString("arena_name");
      $arena_slots = $response->getInt("arena_slots");
      $arena_mode = $response->getString("arena_mode");
      $arena_type = $response->getString("arena_type");
      $arena_ranked = $response->getBool("arena_ranked");
      $arena_type_mode = $response->getString("arena_type_mode");
      var_dump($arena_name, $arena_slots, $arena_mode, $arena_type, $arena_ranked, $arena_type_mode);
    });
  }
  
  public function ranked(Session $session): MenuForm
  {
    $buttons = [];
    foreach(Loader::getInstance()->getQueueManager()->getQueues() as $queue) {
      if ($queue->getModeType() === 1 && $queue->getRanked() === true) {
        $buttons[] = new MenuOption(Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "ranked-button-form"), ["arena_name" => $queue->getName(), "line" => "\n", "type_mode" => "Duel", "queue_players" => count($queue->getPlayers())]);
        }
        return new MenuForm(
        Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "ranked-title-form"),
        Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "ranked-text-form"),
        $buttons,
        function(Player $player, int $selected): void {
          $queue->addPlayer($session);
        });
    }
  }
  
  public function unranked(Session $session): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "unranked-title-form"),
      Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "unranked-text-form"),
      [],
      function(Player $player, int $selected): void {
        //
      }
    );
  }
  
  public function ffa(Session $session): MenuForm
  {
    return new MenuForm(
      Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "ffa-title-form"),
      Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "ffa-text-form"),
      [
        new MenuOption("NoDebuffMap \n FFA - Players: 0")
      ],
      function(Player $player, int $selectedOption): void {
        //
      }
    );
  }
  
}
