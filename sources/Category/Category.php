<?php

namespace IPS\dbcontact;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !\defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * Manage Node
 */
class _Category extends \IPS\Node\Model
{
    protected static $multitons;
	
	public static $databaseColumnOrder = 'categoryPosition';
	
    public static $databaseTable = 'dbcontact_category';
	
    public static $nodeTitle = 'dbcontact_contact_title';
	
	public static $subnodeClass = 'IPS\dbcontact\Category\Item';
	
	public static $seoTitleColumn = 'id';
	
	public static $titleSearchPrefix = 'dbcontact_position_';
	
	public static $databaseColumnEnabledDisabled = 'categoryEnabled';
	
	
	/**
	 * [Node] Get Title
	 *
	 * @return	string|null
	 */	
	protected function get__title()
	{
		return $this->categoryName;
	}
	
	/**
	 * [Node] Get whether or not this node is enabled
	 *
	 * @note	Return value NULL indicates the node cannot be enabled/disabled
	 * @return	bool|null
	 */
	protected function get__enabled()
	{
		return $this->categoryEnabled;
	}

	/**
	 * [Node] Get Description
	 *
	 * @return	string|null
	 */
    protected function get__description()
    {
       return null;
    }
	
	/**
	 * [Node] Set whether or not this node is enabled
	 *
	 * @param	bool|int	$enabled	Whether to set it enabled or disabled
	 * @return	void
	 */
	protected function set__enabled( $enabled )
	{
		$this->categoryEnabled = $enabled;
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
	public function form(&$form)
	{
		$form->add( new \IPS\Helpers\Form\Text( 'dbcontact_categoryName', $this->categoryName ? NULL: NULL, TRUE, [], NULL, NULL, NULL, 'dbcontact_categoryName' ) );
	}

	public function formatFormValues($values)
	{		
		foreach($values as $k => $v)
		{
			if(mb_substr($k, 0, 10) === 'dbcontact_')
			{
				unset($values[$k]);
				$values[ mb_substr($k, 10) ] = $v;
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