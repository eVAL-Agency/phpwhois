<?php
/**
 * whois registration file for fm. TLD
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

class fm_handler {
	function parse($data, $query) {
		$items = [
			'owner'          => 'Registrant',
			'admin'          => 'Admin',
			'tech'           => 'Technical',
			'billing'        => 'Billing',
			'domain.nserver' => 'Name Servers:',
			'domain.created' => 'Created:',
			'domain.expires' => 'Expires:',
			'domain.changed' => 'Modified:',
			'domain.status'  => 'Status:',
			'domain.sponsor' => 'Registrar Name:'
		];

		$r['regrinfo'] = \phpwhois\get_blocks($data['rawdata'], $items);

		$items = [
			'phone number:'  => 'phone',
			'email address:' => 'email',
			'fax number:'    => 'fax',
			'organisation:'  => 'organization'
		];

		if(!empty($r['regrinfo']['domain']['created'])) {
			$r['regrinfo'] = \phpwhois\get_contacts($r['regrinfo'], $items);

			if(count($r['regrinfo']['billing']['address']) > 4) $r['regrinfo']['billing']['address'] =
				array_slice($r['regrinfo']['billing']['address'], 0, 4);

			$r['regrinfo']['registered'] = 'yes';
			\phpwhois\format_dates($r['regrinfo']['domain'], 'dmY');
		}
		else {
			$r                           = '';
			$r['regrinfo']['registered'] = 'no';
		}

		$r['regyinfo']['referrer']  = 'http://www.dot.dm';
		$r['regyinfo']['registrar'] = 'dotFM';

		return $r;
	}
}
