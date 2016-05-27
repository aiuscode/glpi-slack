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

include ('../../../inc/includes.php');

$plugin = new Plugin();
if ($plugin->isActivated("glpislack")) {
   $PluginGlpislackConfig = new PluginGlpislackConfig();

   Session::checkRight("config", UPDATE);

   if (isset($_POST["update"])) {
      $PluginGlpislackConfig->update($_POST);
      Html::back();

   } else {
      Html::header(PluginGlpislack::getTypeName(2), '', "tools", "pluginglpislack", "glpislack");
      $PluginGlpislackConfig->showForm();
      Html::footer();
   }

} else {
   Html::header(__('Setup'), '', "config", "plugins");
   echo "<div class='center'><br><br>".
         "<img src=\"".$CFG_GLPI["root_doc"]."/pics/warning.png\" alt='warning'><br><br>";
   echo "<b>".__('Please activate the plugin','addressing')."</b></div>";
   Html::footer();
}
?>