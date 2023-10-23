<?php
/**
 * @brief		(db) Contact Application Class
 * @author		<a href='https://graffhub.eu'>dottbuff</a>
 * @copyright	(c) 2023 dottbuff
 * @package		Invision Community
 * @subpackage	(db) Contact
 * @since		20 Sep 2023
 * @version		
 */
 
namespace IPS\dbcontact;

/**
 * (db) Contact Application Class
 */
class _Application extends \IPS\Application
{
	/**
	 * [Node] Get Icon for tree
	 *
	 * @note	Return the class for the icon (e.g. 'globe')
	 * @return	string|null
	 */
	protected function get__icon()
	{
		return 'users';
	}
}