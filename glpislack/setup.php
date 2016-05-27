<?php
/*
 * @version $Id: HEADER 15930 2011-10-25 10:47:55Z jmd $
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

// Init the hooks of the plugins -Needed
function plugin_init_glpislack() {
   global $PLUGIN_HOOKS,$CFG_GLPI;

   $PLUGIN_HOOKS['csrf_compliant']['glpislack'] = true;

   $PLUGIN_HOOKS['change_profile']['glpislack'] = array('PluginGlpislackProfile', 'initProfile');

   Plugin::registerClass('PluginGlpislackProfile',
                         array('addtabon' => array('Profile')));

   
   
   if (Session::getLoginUserID()) {
      if (Session::haveRight('plugin_glpislack', READ)) {
         $PLUGIN_HOOKS["menu_toadd"]['glpislack'] = array('tools'  => 'PluginGlpislackMenu');
      }

      if (Session::haveRight('plugin_glpislack', UPDATE)) {
         $PLUGIN_HOOKS['use_massive_action']['glpislack']   = 1;
      }

      // Config page
      if (Session::haveRight("config", UPDATE)) {
         $PLUGIN_HOOKS['config_page']['glpislack']             = 'front/config.form.php';
      }

      // // Add specific files to add to the header : javascript or css
      // $PLUGIN_HOOKS['add_css']['glpislack']        = "glpislack.css";
      // $PLUGIN_HOOKS['add_javascript']['glpislack'] = 'glpislack.js';

      $PLUGIN_HOOKS['post_init']['glpislack'] = array('PluginGlpislack', 'postinit');
   }
}


// Get the name and the version of the plugin - Needed
function plugin_version_glpislack() {

   return array('name'           => 'Slack Notifier',
                'version'        => '0.1',
                'author'         => 'Bertrand Ennouchy',
                'license'        => 'GPLv2+',
                'homepage'       => 'https://github.com/Sburb/glpi-slack',
                'minGlpiVersion' => '0.85');// For compatibility / no install in version < 0.80
}


// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_glpislack_check_prerequisites() {

   // Strict version check (could be less strict, or could allow various version)
   if (version_compare(GLPI_VERSION,'0.85','lt') /*|| version_compare(GLPI_VERSION,'0.84','gt')*/) {
      echo "This plugin requires GLPI >= 0.85";
      return false;
   }
   return true;
}


// Check configuration process for plugin : need to return true if succeeded
// Can display a message only if failure and $verbose is true
function plugin_glpislack_check_config($verbose=false) {
   if (true) { // Your configuration check
      return true;
   }

   if ($verbose) {
      _e('Installed / not configured', 'example');
   }
   return false;
}
?>