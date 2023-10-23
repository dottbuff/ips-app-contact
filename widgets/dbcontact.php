<?php
/**
 * @brief		dbcontact Widget
 * @author		<a href='https://www.invisioncommunity.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) Invision Power Services, Inc.
 * @license		https://www.invisioncommunity.com/legal/standards/
 * @package		Invision Community
 * @subpackage	dbcontact
 * @since		20 Sep 2023
 */

namespace IPS\dbcontact\widgets;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !\defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * dbcontact Widget
 */
class _dbcontact extends \IPS\Widget
{
	/**
	 * @brief	Widget Key
	 */
	public $key = 'dbcontact';
	
	/**
	 * @brief	App
	 */
	public $app = 'dbcontact';
		
	/**
	 * @brief	Plugin
	 */
	public $plugin = '';
	
	/**
	 * Initialise this widget
	 *
	 * @return void
	 */ 
	public function init()
	{
		\IPS\Output::i()->cssFiles = array_merge(\IPS\Output::i()->cssFiles, \IPS\Theme::i()->css( 'dbcontact.css', 'dbcontact', 'front' ) );
		\IPS\Output::i()->jsFiles = array_merge(\IPS\Output::i()->jsFiles, \IPS\Output::i()->js( 'clipboard.min.js', 'dbcontact', 'front' ) );
		$this->template( array( \IPS\Theme::i()->getTemplate( 'widgets', $this->app, 'front' ), $this->key ) );
		parent::init();
	}
	
	/**
	 * Specify widget configuration
	 *
	 * @param	null|\IPS\Helpers\Form	$form	Form object
	 * @return	null|\IPS\Helpers\Form
	 */
	public function configuration( &$form=null )
	{
 		$form = parent::configuration( $form );

 		// $form->add( new \IPS\Helpers\Form\XXXX( .... ) );
 		return $form;
 	} 
 	
 	 /**
 	 * Ran before saving widget configuration
 	 *
 	 * @param	array	$values	Values from form
 	 * @return	array
 	 */
 	public function preConfig( $values )
 	{
 		return $values;
 	}

	/**
	 * Render a widget
	 *
	 * @return	string
	 */
	public function render()
	{
		$data = [];

		foreach ( \IPS\Db::i()->select( '*', 'dbcontact_category', [ 'categoryEnabled = ?', 1 ], 'categoryPosition ASC' ) as $category ) :
			$category['users'] = [];

			foreach ( \IPS\Db::i()->select( '*', 'dbcontact_items', [ 'itemEnabled = ? AND categoryId = ?', 1, $category['id'] ], 'itemPosition ASC' ) as $user ) :
				$user['itemLinks'] = json_decode( $user['itemLinks'], true );
				$user['userId'] = \IPS\Member::load( $user['userId'] );

				$category['users'][] = $user;
			endforeach;

			$data[] = $category;
		endforeach;

		return $this->output( $data );
	}
}