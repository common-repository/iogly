=== Iogly ===
Contributors: iogly
Tags: intrusion detection, security, web application firewall, waf
Requires at least: 4.4
Requires PHP: 5.3
Tested up to: 5.3
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Keep your WordPress installation secure with the Iogly real time intrusion detection system.

== Description ==

This plugin integrates WordPress with the Iogly real time intrusion detection system.

=== Intrusion Detection SaaS ===

* Actively monitors all files of your WP installation
* Actively monitors your WP database

=== Why use an intrusion detection system? ===

If you are running a web application, you are at risk of being hacked. The fallout of such an incident can be very expensive. Cleanup, forensics, increase in insurance premiums and loss of reputation can easily cost 10s of thousands of dollars. Iogly helps to mitigate that risk. Even if you run a fully patched system there is still the risk of undisclosed vulnerabilities and vulnerabilities in 3rd party plugins & libraries. From a practical perspective it is also often not possible to patch your system right when a patch becomes available. Our vulnerability independent scanner will cover you in these situations.

For more information on Iogly please visit [https://iogly.com](https://iogly.com).

The main purpose of this plugin is to sync WP's auto update mechanism with Iogly's monitoring. This plugin will make API calls to the Iogly API (no data will be transmitted during these calls).

[We take your privacy serious](https://iogly.com/privacy)
Please also review our [Terms & Conditions](https://iogly.com/terms)


== Screenshots ==

1. Iogly dashboard. The central hub to monitor your install.
2. Incident details. These are the specifics of an incident.
3. Incidents list. All current and previous incidents will be listed here.
4. Edit instance. You can fine tune the monitoring preferences to suite your specific needs.
5. Instance list. You can monitor multiple installations from one central Iogly account.
6. Download page. Here you can find the latest version of our beacon software.

== Installation ==

1. Unzip the content of the plugin zip to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress Admin
3. Navigate to 'Settings' > 'Iogly'
4. Enter the Iogly API key (the key can be found in the Iogly admin in 'Instances' > 'View')

== Changelog ==

= 1.0 =
* Initial release.

= 1.0.1 =
* Minor updates.
