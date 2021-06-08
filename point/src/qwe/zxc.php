<?php

namespace qwe;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use onebone\economyapi\EconomyAPI;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\utils\Config;

class zxc extends PluginBase implements Listener
{
    private $playerlist = [];

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§aทำงาน");
        @mkdir($this->getDataFolder() . "data/");
        @mkdir($this->getDataFolder() . "top/");
        $this->saveDefaultConfig();
    }
    public function onCommand(CommandSender $sender, Command $cmd, String $label, array $args): bool
    {
        switch ($cmd->getName()) {
            case "point":
                $this->formui($sender);
                break;
        }
        return true;
    }

    public function formui(Player $sender)
    {
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender,  int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case "0";
                    $name = $sender->getName();
                    $topp = ('top');
                    $sss = new Config($this->getDataFolder() . "top/" . strtolower($topp) . ".yml", Config::YAML);
                    $sss->exists("$name");
                    $sss->save();
                    $sss = new Config($this->getDataFolder() . "top/" . strtolower($topp) . ".yml", Config::YAML);
                    $wallet = $sss->getAll();
                    $message = "";
                    $top = "§4[§cT§6O§eP§6 §eคนเติมเยอะๆ §4]";
                    arsort($wallet);
                    $oo = 1;
                    foreach ($wallet as $name => $amount) {
                        $message .= "§b " . $oo . ". §6" . $name . "  §aPoint  §f" . $amount . " §r\n";
                        if ($oo > 9) {
                        }
                        ++$oo;
                    }
                    $sender->sendMessage("$top\n$message");
                    break;

                case "1";
                    if ($sender->hasPermission("op")) {
                        $this->formui11($sender);
                    }
                    break;

                case "2";
                    $this->formui2($sender);
                    break;

                case "3";
                    $this->formui3($sender);
                    break;
            }
        });
        $name = $sender->getName();
        $AIS = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
        $a = $AIS->get("point");
        $form->setTitle("UIMMO");
        $form->setContent("Hi: $name\nPoint : $a");
        $form->addButton("TOP Point", 0, "textures/ไปเอารูปมาใส่");
        $form->addButton("Admin", 0, "textures/ไปเอารูปมาใส่");
        $form->addButton("แลกเงิน", 0, "textures/ไปเอารูปมาใส่");
        $form->addButton("แลกitem", 0, "textures/ไปเอารูปมาใส่");
        $form->sendToPlayer($sender);
        return $form;
    }

    public function formui11(Player $sender)
    {
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender,  int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case "0";
                if ($sender->hasPermission("op")) {
                    $this->formui1($sender);
                }
                break;

                case "1";
                    if ($sender->hasPermission("op")) {
                        $this->formui12($sender);
                    }
                break;
                case "2";
                    if ($sender->hasPermission("op")) {
                        $this->formui($sender);
                    }
                break;

                
            }
        });
        $name = $sender->getName();
        $AIS = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
        $a = $AIS->get("point");
        $form->setTitle("UIMMO");
        $form->setContent("Hi: $name\nPoint : $a");
        $form->addButton("getPoint", 0, "textures/ไปเอารูปมาใส่");
        $form->addButton("setPoint", 0, "textures/ไปเอารูปมาใส่");
        $form->addButton("กลับ", 0, "textures/ไปเอารูปมาใส่");
        $form->sendToPlayer($sender);
        return $form;
    }

    public function formui1(Player $sender)
    {
        $list = [];
        foreach($this->getServer()->getOnlinePlayers() as $online){
            $list[] = $online->getName();
        }
        $this->playerlist[$sender->getName()] = $list;
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $sender, $data = null) {
            $gameyou = $data[2];
            if ($data !== null) {
                if (ctype_digit($gameyou)) {
                $name = $data[1];
                $fg = $data[2];
                $yt = ('top');
                $playergg = $this->playerlist[$sender->getName()] [$name];
                $kdata = new Config($this->getDataFolder() . "data/" . strtolower($playergg) . ".yml", Config::YAML);
                $kdat123 = new Config($this->getDataFolder() . "top/" . strtolower($yt) . ".yml", Config::YAML);
                $kdata->set("point", $kdata->get("point") + $fg);
                $kdat123->set("$playergg", $kdat123->get("$playergg") + $fg);
                $kdata->save();
                $kdat123->save();
                }else {
                    $sender->sendMessage("§l§cใส่ตัวเลขเท่านั้น");
                }
        }});
        $form->setTitle("§fPoint");
        $form->addLabel("Admin");
        $form->addDropdown("playerlist", $this->playerlist[$sender->getName()]);
        $form->addInput("§fgetpoint\n");
        $form->sendToPlayer($sender);
    }

    public function formui12(Player $sender)
    {
        $list = [];
        foreach($this->getServer()->getOnlinePlayers() as $online){
            $list[] = $online->getName();
        }
        $this->playerlist[$sender->getName()] = $list;
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $sender, $data = null) {
            $gameyou = $data[2];
            if ($data !== null) {
                if (ctype_digit($gameyou)) {
                $name = $data[1];
                $fg = $data[2];
                $yt = ('top');
                $playergg = $this->playerlist[$sender->getName()] [$name];
                $kdata = new Config($this->getDataFolder() . "data/" . strtolower($playergg) . ".yml", Config::YAML);
                $kdat123 = new Config($this->getDataFolder() . "top/" . strtolower($yt) . ".yml", Config::YAML);
                $kdata->set("point", $fg);
                $kdat123->set("$playergg", $fg);
                $kdata->save();
                $kdat123->save();
            }else {
                $sender->sendMessage("§l§cใส่ตัวเลขเท่านั้น");
            }
        }});
        $form->setTitle("§fPoint");
        $form->addLabel("Admin");
        $form->addDropdown("playerlist", $this->playerlist[$sender->getName()]);
        $form->addInput("§fsetpoint\n");
        $form->sendToPlayer($sender);
    }

    public function formui2(Player $sender)
    {
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender,  int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            /* สาเหตุที่ให้มีแลกอันเดียวเพราะ ขก.
			   ลองเพิ่มเองดูนะคับเช่น 
			   case "0";
				$point = 50;
				$name = $sender->getName();
				$sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
				$ggms = $sss->get("point");
				if($ggms >= $point){
					$name = $sender->getName();
					$sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
					$sss->exists("point");
					$sss->set("point", $sss->get("point") - $point);
					$sss->save();
					$economy = EconomyAPI::getInstance();
					$mymoney = $economy->myMoney($sender);
					$cash1 = 50000;
					$economy->addMoney($sender, $cash1);
					$sender->sendMessage("§l§dทำการแลกเงิน§l§e $cash1 §aบาทเรียบร้อย");
				} else {
					$sender->sendMessage("§cคุณมี Point ไม่พอ");
				}
				break;   */
            switch ($result) {
                case "0";
                    $point = 50;
                    $name = $sender->getName();
                    $sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
                    $ggms = $sss->get("point");
                    if ($ggms >= $point) {
                        $name = $sender->getName();
                        $sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
                        $sss->exists("point");
                        $sss->set("point", $sss->get("point") - $point);
                        $sss->save();
                        $economy = EconomyAPI::getInstance();
                        $mymoney = $economy->myMoney($sender);
                        $cash1 = 50000;
                        $economy->addMoney($sender, $cash1);
                        $sender->sendMessage("§l§dทำการแลกเงิน§l§e $cash1 §aบาทเรียบร้อย");
                    } else {
                        $sender->sendMessage("§cคุณมี Point ไม่พอ");
                    }
                    break;
                    case "1";
                    $point = 50;
                    $name = $sender->getName();
                    $sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
                    $ggms = $sss->get("point");
                    if ($ggms >= $point) {
                        $name = $sender->getName();
                        $sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
                        $sss->exists("point");
                        $sss->set("point", $sss->get("point") - $point);
                        $sss->save();
                        $economy = EconomyAPI::getInstance();
                        $mymoney = $economy->myMoney($sender);
                        $cash1 = 50000;
                        $economy->addMoney($sender, $cash1);
                        $sender->sendMessage("§l§dทำการแลกเงิน§l§e $cash1 §aบาทเรียบร้อย");
                    } else {
                        $sender->sendMessage("§cคุณมี Point ไม่พอ");
                    }
                    break;
            }
        });
        $form->setTitle("Point");
        $name = $sender->getName();
        $sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
        $sss->get("point");
        $form->setContent("§f§eว่าไง $name\n\n§fยอดเงินใน point ของคุณมี " . $sss->get("point") . "\n§f- \n§fบล่าาาาาาา");
        $form->addButton("§cPoint\n§e50 §aPoint = §b50,000");
        $form->addButton("§cPoint\n§e50 §aPoint = §b50,000");
        $form->sendToPlayer($sender);
        return $form;
    }

    public function formui3(Player $sender)
    {
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender,  int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            /* สาเหตุที่ให้มีแลกอันเดียวเพราะ ขก.
			   ลองเพิ่มเองดูนะคับเช่น
			   case 0:
				$point = 50;
				$name = $sender->getName();
				$sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
				$ggms = $sss->get("point");
				if($ggms >= $point){
					$name = $sender->getName();
					$sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
					$sss->exists("point");
					$sss->set("point", $sss->get("point") - $point);
					$sss->save();
					$dragon = Item::get(276,0,1);
					$dragon->setCustomName("§l§ａดาบ");
					$id = Enchantment::getEnchantment(9);
					$lv = 50;
					$dragon->addEnchantment(new EnchantmentInstance($id, (int) $lv));
					$id = Enchantment::getEnchantment(13);
					$lv = 5;
					$dragon->addEnchantment(new EnchantmentInstance($id, (int) $lv));
					$id = Enchantment::getEnchantment(12);
					$lv = 5;
					$dragon->addEnchantment(new EnchantmentInstance($id, (int) $lv));
					$id = Enchantment::getEnchantment(14);
					$lv = 5;
					$dragon->addEnchantment(new EnchantmentInstance($id, (int) $lv));
					
					$sender->getInventory()->addItem($dragon);
					$sender->sendMessage("§l§WoW");
				} else {
					$sender->sendMessage("§cคุณมี Point ไม่พอ");
				}
				break;*/
            switch ($result) {
                case 0:
                    $point = 50;
                    $name = $sender->getName();
                    $sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
                    $ggms = $sss->get("point");
                    if ($ggms >= $point) {
                        $name = $sender->getName();
                        $sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
                        $sss->exists("point");
                        $sss->set("point", $sss->get("point") - $point);
                        $sss->save();
                        $dragon = Item::get(276, 0, 1);
                        $dragon->setCustomName("§l§ａดาบ");
                        $sender->getInventory()->addItem($dragon);
                        $sender->sendMessage("§l§aPornhub");
                    } else {
                        $sender->sendMessage("§cคุณมี Point ไม่พอ");
                    }
                    break;
                    case 1:
                        $point = 50;
                        $name = $sender->getName();
                        $sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
                        $ggms = $sss->get("point");
                        if ($ggms >= $point) {
                            $name = $sender->getName();
                            $sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
                            $sss->exists("point");
                            $sss->set("point", $sss->get("point") - $point);
                            $sss->save();
                            $dragon = Item::get(276, 0, 1);
                            $dragon->setCustomName("§l§ａดาบ");
                            $sender->getInventory()->addItem($dragon);
                            $sender->sendMessage("§l§aPornhub");
                        } else {
                            $sender->sendMessage("§cคุณมี Point ไม่พอ");
                        }
                        break;
            }
        });
        $form->setTitle("Point");
        $name = $sender->getName();
        $sss = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
        $sss->get("point");
        $form->setContent("§f§eว่าไง $name\n\n§fยอดเงินใน point ของคุณมี " . $sss->get("point") . "\n§f- \n§fบล่าาาาาาา");
        $form->addButton("§lSword\nPoint §a50");
        $form->addButton("§lSword\nPoint §a50");
        $form->sendToPlayer($sender);
    }

    public function getPoint($name)
    {
        $data = new Config($this->getDataFolder() . "data/" . strtolower($name) . ".yml", Config::YAML);
        return $data->get("point");
    }

    public function onJoin(PlayerJoinEvent $e)
    {
        $player = $e->getPlayer();
        $p = $player->getName();
        $exp = new Config($this->getDataFolder() . "data/" . strtolower($p) . ".yml", Config::YAML);
        $exp->set("point", $exp->get("point") + 0);
        $exp->save();
        
    }
}
