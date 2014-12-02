<?php
/**
 * whois registration file for ca. TLD
 *
 * @package phpwhois
 *
 * @copyright 1999,2005 easyDNS Technologies Inc. & Mark Jeftovic
 * @author David Saez
 * @link http://www.phpwhois.org Original version of phpwhois
 *
 * @author Dmitry Lukashin <http://lukashin.ru/en/>
 * @link http://phpwhois.pw/ Revisited version of phpwhois
 *
 * @author Charlie Powell
 *
 * @license GPLv2
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace phpwhois\whois\domain;

class ca_handler {
	function parse($data_str, $query) {
		$items = [
			'owner'          => 'Registrant:',
			'admin'          => 'Administrative contact:',
			'tech'           => 'Technical contact:',
			'domain.sponsor' => 'Registrar:',
			'domain.nserver' => 'Name servers:',
			'domain.status'  => 'Domain status:',
			'domain.created' => 'Creation date:',
			'domain.expires' => 'Expiry date:',
			'domain.changed' => 'Updated date:'
		];

		$extra = [
			'postal address:' => 'address.0',
			'job title:'      => '',
			'number:'         => 'handle',
			'description:'    => 'organization'
		];

		$r['regrinfo'] = easy_parser($data_str['rawdata'], $items, 'ymd', $extra);

		if(!empty($r['regrinfo']['domain']['sponsor'])) {
			list($v, $reg) = explode(':', $r['regrinfo']['domain']['sponsor'][0]);
			$r['regrinfo']['domain']['sponsor'] = trim($reg);
		}

		if(empty($r['regrinfo']['domain']['status']) || $r['regrinfo']['domain']['status'] == 'available')
			$r['regrinfo']['registered'] = 'no';
		else
			$r['regrinfo']['registered'] = 'yes';

		$r['regyinfo'] = [
			'registrar' => 'CIRA',
			'referrer'  => 'http://www.cira.ca/'
		];

		return $r;
	}
}

?>