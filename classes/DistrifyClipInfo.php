<?php
/**
 * Created by PhpStorm.
 * User: saschaaeppli
 * Date: 27.03.17
 * Time: 14:31
 */

namespace Ffte\Movies\Classes;


class DistrifyClipInfo implements ClipInfo
{

    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * embed code for
     * @return string
     */
    public function getEmbedUrl()
    {
        return "https://embeds.distrify.com/player/{$this->id}";
    }

    public function getProvider()
    {
        return 'Distrify';
    }

    public function getThumbnailUrl()
    {
        $context = stream_context_create(
            array(
                'http' => array(
                    'follow_location' => false
                )
            )
        );

        // follow redirect
        file_get_contents("https://distrify.com/opengraph/images/landscape/{$this->id}", false, $context);
        // parse header
        $headers = parseHeaders($http_response_header);
        // read 'Location' header
        return $headers['Location'];
    }
}

function parseHeaders( $headers )
{
    $head = array();
    foreach( $headers as $k=>$v )
    {
        $t = explode( ':', $v, 2 );
        if( isset( $t[1] ) )
            $head[ trim($t[0]) ] = trim( $t[1] );
        else
        {
            $head[] = $v;
            if( preg_match( "#HTTP/[0-9\.]+\s+([0-9]+)#",$v, $out ) )
                $head['reponse_code'] = intval($out[1]);
        }
    }
    return $head;
}
