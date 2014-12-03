<?php
/**
 * PHPWhois IR lookup Extension - http://github.com/sepehr/phpwhois-ir
 *
 * An extension to PHPWhois (http://phpwhois.org) library to support IR lookups.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace phpwhois\whois\domain;

/**
 * IR Domain names lookup handler class.
 */
class ir_handler {
	function parse($data_str, $query) {
		$translate = [
			'nic-hdl' => 'handle',
			'org'     => 'organization',
			'e-mail'  => 'email',
			'person'  => 'name',
			'fax-no'  => 'fax',
			'domain'  => 'name'
		];

		$contacts = [
			'admin-c'  => 'admin',
			'tech-c'   => 'tech',
			'holder-c' => 'owner'
		];

		$reg = \phpwhois\generic_parser_a($data_str['rawdata'], $translate, $contacts, 'domain', 'Ymd');

		$r['regrinfo'] = $reg;
		$r['regyinfo'] = [
			'referrer'  => 'http://whois.nic.ir/',
			'registrar' => 'NIC-IR'
		];

		return $r;
	}
}
