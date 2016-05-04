<?php namespace Bogardo\Mailgun\Mailgun;

use Illuminate\Support\Facades\Config;

class Lists
{
    /**
     * Mailgun Object
     *
     * @var \Bogardo\Mailgun\Mailgun\Lists
     */
    private $mailgun;

    /**
     * Sets the Mailgun Object
     */
    public function __construct($mailgun)
    {
        $this->mailgun = $mailgun;
    }

    /**
     * Gets all the Lists
     */
    public function all()
    {
        $data = $this->mailgun->get('lists');
        return $data->http_response_body;
    }

    /**
     * Gets a specific List
     *
     * @param string $list_address
     */
    public function get($list_address)
    {
        $uri = 'lists/' . $list_address;
        $data = $this->mailgun->get($uri);
        return $data->http_response_body;
    }

    /**
     * Creates a new List
     *
     * @param array $params
     */
    public function create($params)
    {
        $data = $this->mailgun->post('lists', $params);
        return $data->http_response_body;
    }

    /**
     * Updates an existing List
     *
     * @param string $list_address
     * @param array $params
     */
    public function update($list_address, $params)
    {
        $uri = 'lists/' . $list_address;
        $data = $this->mailgun->put($uri, $params);
        return $data->http_response_body;
    }

    /**
     * Deletes a List
     * @param string $list_address
     */
    public function delete($list_address)
    {
        $uri = 'lists/' . $list_address;
        $data = $this->mailgun->delete($uri);
        return $data->http_response_body;
    }

    /**
     * Gets members from a list
     *
     * @param string $list_address
     * @param string $member_address
     */
    public function getMember($list_address, $member_address = NULL)
    {
        $uri = 'lists/' . $list_address . '/members';
        if( ! empty($member_address))
        {
            $uri .= '/' . $member_address;
        }
        $data = $this->mailgun->get($uri);
        return $data->http_response_body;
    }

    /**
     * Adds new members to a List
     *
     * @param string $list_address
     * @param array $params
     */
    public function addMember($list_address, $params)
    {
        // Need to wrap the single member into an extra array to use the multi function
        if( ! isset($params[1]))
        {
            $params = array($params);
        }
        $post = array(
            'members' => json_encode($params),
            'subscribed' => true,
        );
        $uri = 'lists/' . $list_address . '/members.json';
        $data = $this->mailgun->post($uri, $post);
        return $data->http_response_body;
    }

    /**
     * Updates a list member
     *
     * @param string $list_address
     * @param string $member_address
     * @param array $params
     */
    public function updateMember($list_address, $member_address, $params)
    {
        $uri = 'lists/' . $list_address . '/members/' . $member_address;
        $data = $this->mailgun->put($uri, $params);
        return $data->http_response_body;
    }

    /**
     * Removes a member from a list
     *
     * @param string $list_address
     * @param string $memberaddress
     */
    public function deleteMember($list_address, $member_address)
    {
        $uri = 'lists/' . $list_address . '/members/' . $member_address;
        $data = $this->mailgun->delete($uri);
        return $data->http_response_body;
    }
}