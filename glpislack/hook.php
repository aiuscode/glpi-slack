<?php
/*
 * @version $Id: hook.php 219 2013-11-25 19:01:42Z webmyster $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2011 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------

// Hook called on profile change
// Good place to evaluate the user right on this plugin
// And to save it in the session
function plugin_change_profile_example() {
   // For example : same right of computer
   if (Session::haveRight('computer','w')) {
      $_SESSION["glpi_plugin_example_profile"] = array('example' => 'w');

   } else if (Session::haveRight('computer','r')) {
      $_SESSION["glpi_plugin_example_profile"] = array('example' => 'r');

   } else {
      unset($_SESSION["glpi_plugin_example_profile"]);
   }
}


// Define dropdown relations
function plugin_example_getDatabaseRelations() {
   return array("glpi_plugin_example_dropdowns" => array("glpi_plugin_example" => "plugin_example_dropdowns_id"));
}


// Define Dropdown tables to be manage in GLPI :
function plugin_example_getDropdown() {
   // Table => Name
   return array('PluginExampleDropdown' => __("Plugin Example Dropdown", 'example'));
}



////// SEARCH FUNCTIONS ///////(){

// Define Additionnal search options for types (other than the plugin ones)
function plugin_example_getAddSearchOptions($itemtype) {
   $sopt = array();
   if ($itemtype == 'Computer') {
         // Just for example, not working...
         $sopt[1001]['table']     = 'glpi_plugin_example_dropdowns';
         $sopt[1001]['field']     = 'name';
         $sopt[1001]['linkfield'] = 'plugin_example_dropdowns_id';
         $sopt[1001]['name']      = __('Example plugin', 'example');
   }
   return $sopt;
}

// See also PluginExampleExample::getSpecificValueToDisplay()
function plugin_example_giveItem($type,$ID,$data,$num) {
   $searchopt = &Search::getOptions($type);
   $table = $searchopt[$ID]["table"];
   $field = $searchopt[$ID]["field"];

   switch ($table.'.'.$field) {
      case "glpi_plugin_example_examples.name" :
         $out = "<a href='".Toolbox::getItemTypeFormURL('PluginExampleExample')."?id=".$data['id']."'>";
         $out .= $data[$num][0]['name'];
         if ($_SESSION["glpiis_ids_visible"] || empty($data[$num][0]['name'])) {
            $out .= " (".$data["id"].")";
         }
         $out .= "</a>";
         return $out;
   }
   return "";
}


function plugin_example_displayConfigItem($type, $ID, $data, $num) {
   $searchopt = &Search::getOptions($type);
   $table     = $searchopt[$ID]["table"];
   $field     = $searchopt[$ID]["field"];

   // Example of specific style options
   // No need of the function if you do not have specific cases
   switch ($table.'.'.$field) {
      case "glpi_plugin_example_examples.name" :
         return " style=\"background-color:#DDDDDD;\" ";
   }
   return "";
}


function plugin_example_addDefaultJoin($type, $ref_table, &$already_link_tables) {
   // Example of default JOIN clause
   // No need of the function if you do not have specific cases
   switch ($type) {
//       case "PluginExampleExample" :
      case "MyType" :
         return Search::addLeftJoin($type, $ref_table, $already_link_tables,
                                    "newtable", "linkfield");
   }
   return "";
}


function plugin_example_addDefaultSelect($type) {
   // Example of default SELECT item to be added
   // No need of the function if you do not have specific cases
   switch ($type) {
//       case "PluginExampleExample" :
      case "MyType" :
         return "`mytable`.`myfield` = 'myvalue' AS MYNAME, ";
   }
   return "";
}


function plugin_example_addDefaultWhere($type) {
   // Example of default WHERE item to be added
   // No need of the function if you do not have specific cases
   switch ($type) {
//       case "PluginExampleExample" :
      case "MyType" :
         return " `mytable`.`myfield` = 'myvalue' ";
   }
   return "";
}


function plugin_example_addLeftJoin($type, $ref_table, $new_table, $linkfield) {
   // Example of standard LEFT JOIN  clause but use it ONLY for specific LEFT JOIN
   // No need of the function if you do not have specific cases
   switch ($new_table) {
      case "glpi_plugin_example_dropdowns" :
         return " LEFT JOIN `$new_table` ON (`$ref_table`.`$linkfield` = `$new_table`.`id`) ";
   }
   return "";
}


function plugin_example_forceGroupBy($type) {
   switch ($type) {
      case 'PluginExampleExample' :
         // Force add GROUP BY IN REQUEST
         return true;
   }
   return false;
}


function plugin_example_addWhere($link, $nott, $type, $ID, $val, $searchtype) {
   $searchopt = &Search::getOptions($type);
   $table     = $searchopt[$ID]["table"];
   $field     = $searchopt[$ID]["field"];

   $SEARCH = Search::makeTextSearch($val,$nott);

   // Example of standard Where clause but use it ONLY for specific Where
   // No need of the function if you do not have specific cases
    switch ($table.".".$field) {
       /*case "glpi_plugin_example.name" :
          $ADD = "";
          if ($nott && $val!="NULL") {
             $ADD = " OR `$table`.`$field` IS NULL";
          }
          return $link." (`$table`.`$field` $SEARCH ".$ADD." ) ";*/
         case "glpi_plugin_example_examples.serial" :
            return $link." `$table`.`$field` = '$val' ";
    }
   return "";
}


// This is not a real example because the use of Having condition in this case is not suitable
function plugin_example_addHaving($link, $nott, $type, $ID, $val, $num) {
   $searchopt = &Search::getOptions($type);
   $table     = $searchopt[$ID]["table"];
   $field     = $searchopt[$ID]["field"];

   $SEARCH = Search::makeTextSearch($val,$nott);

   // Example of standard Having clause but use it ONLY for specific Having
   // No need of the function if you do not have specific cases
   switch ($table.".".$field) {
      case "glpi_plugin_example.serial" :
         $ADD = "";
         if (($nott && $val!="NULL")
             || $val == '^$') {
            $ADD = " OR ITEM_$num IS NULL";
         }
         return " $LINK ( ITEM_".$num.$SEARCH." $ADD ) ";
   }
   return "";
}


function plugin_example_addSelect($type,$ID,$num) {
   $searchopt = &Search::getOptions($type);
   $table     = $searchopt[$ID]["table"];
   $field     = $searchopt[$ID]["field"];

// Example of standard Select clause but use it ONLY for specific Select
// No need of the function if you do not have specific cases
// switch ($table.".".$field) {
//    case "glpi_plugin_example.name" :
//       return $table.".".$field." AS ITEM_$num, ";
// }
   return "";
}


function plugin_example_addOrderBy($type,$ID,$order,$key=0) {
   $searchopt = &Search::getOptions($type);
   $table     = $searchopt[$ID]["table"];
   $field     = $searchopt[$ID]["field"];

// Example of standard OrderBy clause but use it ONLY for specific order by
// No need of the function if you do not have specific cases
// switch ($table.".".$field) {
//    case "glpi_plugin_example.name" :
//       return " ORDER BY $table.$field $order ";
// }
   return "";
}


//////////////////////////////
////// SPECIFIC MODIF MASSIVE FUNCTIONS ///////


// Define actions :
function plugin_example_MassiveActions($type) {
   switch ($type) {
      // New action for core and other plugin types : name = plugin_PLUGINNAME_actionname
      case 'Computer' :
         return array('PluginExampleExample'.MassiveAction::CLASS_ACTION_SEPARATOR.'DoIt' =>
                                                              __("plugin_example_DoIt", 'example'));

      // Actions for types provided by the plugin are included inside the classes
   }
   return array();
}


// How to display specific update fields ?
// options must contain at least itemtype and options array
function plugin_example_MassiveActionsFieldsDisplay($options=array()) {
   //$type,$table,$field,$linkfield

   $table     = $options['options']['table'];
   $field     = $options['options']['field'];
   $linkfield = $options['options']['linkfield'];

   if ($table == getTableForItemType($options['itemtype'])) {
      // Table fields
      switch ($table.".".$field) {
         case 'glpi_plugin_example_examples.serial' :
            _e("Not really specific - Just for example", 'example');
            //Html::autocompletionTextField($linkfield,$table,$field);
            // Dropdown::showYesNo($linkfield);
            // Need to return true if specific display
            return true;
      }

   } else {
      // Linked Fields
      switch ($table.".".$field) {
         case "glpi_plugin_example_dropdowns.name" :
            _e("Not really specific - Just for example", 'example');
            // Need to return true if specific display
            return true;
      }
   }
   // Need to return false on non display item
   return false;
}


// How to display specific search fields or dropdown ?
// options must contain at least itemtype and options array
// MUST Use a specific AddWhere & $tab[X]['searchtype'] = 'equals'; declaration
function plugin_example_searchOptionsValues($options=array()) {
   $table = $options['searchoption']['table'];
   $field = $options['searchoption']['field'];

    // Table fields
   switch ($table.".".$field) {
      case "glpi_plugin_example_examples.serial" :
            _e("Not really specific - Use your own dropdown - Just for example", 'example');
            Dropdown::show(getItemTypeForTable($options['searchoption']['table']),
                                               array('value'    => $options['value'],
                                                     'name'     => $options['name'],
                                                     'comments' => 0));
            // Need to return true if specific display
            return true;
   }
   return false;
}


//////////////////////////////

// Hook done on update item case
function plugin_item_update_example($item) {
   Session::addMessageAfterRedirect(sprintf(__("Update Computer Hook (%s)", 'example'),implode(',',$item->updates)), true);
   return true;
}

// Install process for plugin : need to return true if succeeded
function plugin_example_install() {
   global $DB;

   $config = new Config();
   $config->setConfigurationValues('plugin:Example', array('configuration' => false));

   ProfileRight::addProfileRights(array('example:read'));

  if (!TableExists("glpi_plugin_slackglpi_profiles")) {
        $query = "CREATE TABLE `glpi_plugin_slackglpi_profiles` (
                    `id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_profiles (id)',
                    `right` char(1) collate utf8_unicode_ci default NULL,
                    PRIMARY KEY  (`id`)
                  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

        $DB->query($query) or die("error creating glpi_plugin_slackglpi_profiles ". $DB->error());

        //creation of the first profile after installation
        $id = $_SESSION['glpiactiveprofile']['id'];
        $query = "INSERT INTO glpi_plugin_slackglpi_profiles VALUES ('$id','w')";

        $DB->query($query) or die("error populate glpi_plugin_slackglpi_profiles".$DB->error());
   }

   if (!TableExists("glpi_plugin_slackglpi_config")) {
      $query = "CREATE TABLE `glpi_plugin_slackglpi_config` (
                  `id` int(11) NOT NULL auto_increment,
                  `webhook_url` varchar(255) collate utf8_unicode_ci default NULL,
                  `on_creation` tinyint(1) NOT NULL default '1',
                  `on_update` tinyint(1) NOT NULL default '0',
                PRIMARY KEY (`id`)
               ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
      $DB->query($query) or die("error creating glpi_plugin_slackglpi_config ". $DB->error());
   }

}


// Uninstall process for plugin : need to return true if succeeded
function plugin_example_uninstall() {
   global $DB;

   $config = new Config();
   $config->deleteConfigurationValues('plugin:Slackglpi', array('configuration' => false));

   ProfileRight::deleteProfileRights(array('example:read'));

   $notif = new Notification();
   $options = array('itemtype' => 'Ticket',
                    'event'    => 'plugin_example',
                    'FIELDS'   => 'id');
   foreach ($DB->request('glpi_notifications', $options) as $data) {
      $notif->delete($data);
   }
   // Old version tables
   if (TableExists("glpi_plugin_slackglpi_profiles")) {
      $query = "DROP TABLE `glpi_plugin_slackglpi_profiles`";
      $DB->query($query) or die("error deleting glpi_plugin_slackglpi_profiles");
   }
   if (TableExists("glpi_plugin_slackglpi_config")) {
      $query = "DROP TABLE `glpi_plugin_slackglpi_config`";
      $DB->query($query) or die("error deleting glpi_plugin_slackglpi_config");
   }
   return true;
}


function plugin_example_AssignToTicket($types) {
   $types['PluginExampleExample'] = "Example";
   return $types;
}


function plugin_example_get_events(NotificationTargetTicket $target) {
   $target->events['plugin_example'] = __("Example event", 'example');
}


function plugin_example_get_datas(NotificationTargetTicket $target) {
   $target->datas['##ticket.example##'] = __("Example datas", 'example');
}


function plugin_example_postinit() {
   global $CFG_GLPI;

   // All plugins are initialized, so all types are registered
   foreach (Infocom::getItemtypesThatCanHave() as $type) {
      // do something
   }
}

// Check to add to status page
function plugin_example_Status($param) {
   // Do checks (no check for example)
   $ok = true;
   echo "example plugin: example";
   if ($ok) {
      echo "_OK";
   } else {
      echo "_PROBLEM";
      // Only set ok to false if trouble (global status)
      $param['ok'] = false;
   }
   echo "\n";
   return $param;
}

function plugin_example_display_central() {
   echo "<tr><th colspan='2'>";
   echo "<div style='text-align:center; font-size:2em'>";
   echo __("Plugin example displays on central page", "example");
   echo "</div>";
   echo "</th></tr>";
}

function plugin_example_display_login() {
   echo "<div style='text-align:center; font-size:2em'>";
   echo __("Plugin example displays on login page", "example");
   echo "</div>";
}

?>