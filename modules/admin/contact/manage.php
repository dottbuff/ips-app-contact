<?php


namespace IPS\dbcontact\modules\admin\contact;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !\defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * manage
 */
class _manage extends \IPS\Node\Controller
{
	public static $csrfProtected = TRUE;

	protected $nodeClass = 'IPS\dbcontact\Category';
	
	/**
	 * Execute
	 *
	 * @return	void
	 */
	public function execute()
	{
		\IPS\Dispatcher::i()->checkAcpPermission( 'manage_manage' );
		parent::execute();
	}

	protected function applications()
    {
        $nodeClass = $this->nodeClass;
        try
        {
            $node = $nodeClass::load( \IPS\Request::i()->id );
        }
        catch( \OutOfRangeException $e )
        {
            \IPS\Output::i()->error( 'node_error', '2S101/P', 404, '' );
        }
	}
}