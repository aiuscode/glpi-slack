<?php
/*
 * @version $Id: hook.php 219 2013-11-25 19:01:42Z webmyster $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2011 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of addressing.

 Addressing is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Addressing is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Addressing. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginAddressingConfig extends CommonDBTM {

   function showForm() {

      $this->getFromDB('1');

      $system = $this->fields["used_system"];

      echo "<div class='center'>";
      echo "<form method='post' action='".$this->getFormURL()."'>";

      echo "<table class='tab_cadre_fixe' cellpadding='5'>";
      echo "<tr class='tab_bg_1><th colspan='2'>"."Notifications"."</th></tr>";

      echo "<tr class='tab_bg_2'><td>"."Création Ticket"."</td>";
      echo "<td>";
      Dropdown::showYesNo("alloted_ip",$this->fields["alloted_ip"]);
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_2'><td>"."Modification Ticket"."</td>";
      echo "<td>";
      Dropdown::showYesNo("alloted_ip",$this->fields["alloted_ip"]);
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1><th colspan='2'>"."Configuration Slack"."</th></tr>";
      echo "<tr class='tab_bg_2'><td>"."Incoming Webhook URL"."</td>";
      echo "<td><input type='text' name='slack_inc_webhook' size='40' value='".$CFG_GLPI["admin_email"]."'>";
      if (!isValidSlackWebhookURL($CFG_GLPI["admin_email"])) {
             echo "<span class='red'>&nbsp;".__('Invalid Slack Webhook address')."</span>";
      }
      echo "</td>";
      echo "</tr>";

      echo "<tr><th colspan='2'>";
      echo "<input type='hidden' name='id' value='1'>";
      echo "<div class='center'>".
            "<input type='submit' name='update' value='"._sx('button','Post')."' class='submit'>".
           "</div></th></tr>";
      echo "</table>";
      Html::closeForm();
      echo "</div>";
   }
   
   
   /**
    * Determine if email is valid
    *
    * @param URL         URL to check
    *
    * @return boolean
   **/
   
   function isValidSlackWebhookURL($URL) {

    $isValid  = false;
    
    if(preg_match('/T[A-Z0-9]{8}\/B[A-Z0-9]{8}\/[a-zA-Z0-9]{24}/', $URL)) {
        $isValid  = true;
    }
 
    return $isValid;
   }
   
}

?>