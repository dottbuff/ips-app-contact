<?php

namespace IPS\dbcontact\Category;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !\defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

class _Item extends \IPS\CustomField
{
	protected static $multitons;
	
	public static $databaseColumnOrder = 'itemPosition';
	
	public static $parentNodeColumnId = 'categoryId';
	
    public static $nodeTitle = 'dbcontact_contact_title';

	public static $databasePrefix = '';
	
	public static $databaseTable = 'dbcontact_items';
	
	public static $parentNodeClass = 'IPS\dbcontact\Category';
	
	/**
	 * @brief	[Node] Enabled/Disabled Column
	 */
	public static $databaseColumnEnabledDisabled = 'itemEnabled';
	
	public static $databaseColumnMap = array(
		'content'  => 'options',
		'not_null' => 'required',
		'categoryId' => 'categoryId',
	);

	/**
	 * [Node] Get Title
	 *
	 * @return	string|null
	 */	
	protected function get__title()
	{
		return \IPS\Member::load( $this->userId )->name;
	}
	
	/**
	 * [Node] Get Description
	 *
	 * @return	string|null
	 */
    protected function get__description()
    {
        return \IPS\Member\Group::load( \IPS\Member::load( $this->userId )->member_group_id )->name;
    }

	/**
	 * [Node] Get whether or not this node is enabled
	 *
	 * @note	Return value null indicates the node cannot be enabled/disabled
	 * @return	bool|null
	 */
	protected function get__enabled()
	{
		return $this->itemEnabled;
	}
	
	/**
	 * [Node] Set whether or not this node is enabled
	 *
	 * @param	bool|int	$enabled	Whether to set it enabled or disabled
	 * @return	void
	 */
	protected function set__enabled( $enabled )
	{
		$this->itemEnabled = $enabled;
	}	
	
	/**
	 * [Node] Does the currently logged in user have permission to copy this node?
	 *
	 * @return	bool
	 */
	 
	public function canCopy()
	{
		return false;
	}	
    
	/**
	 * [Node] Add/Edit Form
	 *
	 * @param	\IPS\Helpers\Form	$form	The form
	 * @return	void
	 */
    public function form( &$form )
    {
        $form->addHeader("dbcontact_member");
		$form->add( new \IPS\Helpers\Form\Member( 'dbcontact_userId', $this->userId ? \IPS\Member::load( $this->userId )  : null, true, [], null, null, null, 'dbcontact_userId' ) );
	
        $form->addHeader("dbcontact_links");
        $form->add( new \IPS\Helpers\Form\YesNo( 'dbcontact_message', $this->itemLinks ? json_decode($this->itemLinks, true)['message'] : 0 ) );
        $form->add( new \IPS\Helpers\Form\Text( 'dbcontact_discord', $this->itemLinks ? json_decode($this->itemLinks, true)['discord'] : null, false, [], null, null, null ) );
        $form->add( new \IPS\Helpers\Form\Text( 'dbcontact_steam', $this->itemLinks ? json_decode($this->itemLinks, true)['steam'] : null, false, [], null, null, null ) );
        $form->add( new \IPS\Helpers\Form\Text( 'dbcontact_facebook', $this->itemLinks ? json_decode($this->itemLinks, true)['facebook'] : null, false, [], null, null, null ) );
    }
	
	public function formatFormValues( $values )
	{
		$values['dbcontact_userId'] = $values['dbcontact_userId']->member_id;
        $values['dbcontact_itemLinks'] = json_encode([
            'message'   => $values['dbcontact_message'],
            'discord'   => $values['dbcontact_discord'],
            'steam'     => $values['dbcontact_steam'],
            'facebook'  => $values['dbcontact_facebook']
        ]);
        unset($values['dbcontact_message'], $values['dbcontact_discord'], $values['dbcontact_steam'], $values['dbcontact_facebook']);
		
		foreach( $values as $k => $v )
		{
			if( mb_substr($k, 0, 10) === 'dbcontact_' )
			{
				unset( $values[$k] );
				$values[ mb_substr( $k, 10 ) ] = $v;
			}
		}
		
		return $values;
	}
	
	/**
	* [Node] Save Add/Edit Form
	*
	* @param       array   $values Values from the form
	* @return      void
	*/
	public function saveForm($values)
	{
		if(!$this->id)
		{
			$this->save();
		}
		
		parent::saveForm($values);
	}	
	
	/**
	 * Delete Record
	 *
	 * @return	void
	 */
	public function delete()
	{
		parent::delete();
	}
}