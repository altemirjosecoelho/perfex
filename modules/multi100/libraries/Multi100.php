<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Multi100
{
    private $api_url;
    private $api_key;

    public function setCreds($api_url, $api_key)
    {
        $this->api_url = $api_url;
        $this->api_key = $api_key;
    }

    public function getCreds()
    {
        return [
            'api_url' => $this->api_url,
            'api_key' => $this->api_key
        ];
    }

    /**
     * PLANS
     */
    public function get_plans()
    {
        $url = $this->api_url . '/api/plans';
        $response = $this->send_request('GET', $url, $this->api_key);

        return $response;
    }

    public function  get_plan($id)
    {
        $url = $this->api_url . '/api/plans/' . $id;
        $response = $this->send_request('GET', $url, $this->api_key);

        return $response;
    }

    public function  create_plan($post_data)
    {
        $url = $this->api_url  . '/api/plans';
        $response = $this->send_request('POST', $url, $this->api_key, $post_data);

        return $response;
    }

    public function update_plan($id, $post_data)
    {
        $url = $this->api_url . '/api/plans/' . $id;
        $response = $this->send_request('PUT', $url, $this->api_key, $post_data);

        return $response;
    }

    public function delete_plan($id)
    {
        $url = $this->api_url . '/api/plans/' . $id;
        $response = $this->send_request('DELETE', $url, $this->api_key);

        return $response;
    }

    /**
     * COMPANIES
     */
    public function get_companies()
    {
        $url = $this->api_url . '/api/companies';
        $response = $this->send_request('GET', $url, $this->api_key);

        return $response;
    }

    public function  get_company($id)
    {
        $url = $this->api_url . '/api/companies/' . $id;
        $response = $this->send_request('GET', $url, $this->api_key);

        return $response;
    }

    public function  create_company($post_data)
    {
        $url = $this->api_url . '/api/companies';
        $response = $this->send_request('POST', $url, $this->api_key, $post_data);

        return $response;
    }

    public function update_company($id, $post_data)
    {
        $url = $this->api_url . '/api/companies/' . $id;
        $response = $this->send_request('PUT', $url, $this->api_key, $post_data);

        return $response;
    }

    public function delete_company($id)
    {
        $url = $this->api_url . '/api/companies/' . $id;
        $response = $this->send_request('DELETE', $url, $this->api_key);

        return $response;
    }

    /**
     * HELPERS
     */
    public function get_helps()
    {
        $url = $this->api_url . '/api/helps';
        $response = $this->send_request('GET', $url, $this->api_key);

        return $response;
    }

    public function get_help($id)
    {
        $url = $this->api_url . '/api/helps/' . $id;
        $response = $this->send_request('GET', $url, $this->api_key);

        return $response;
    }

    public function create_help($post_data)
    {
        $url = $this->api_url . '/api/helps';
        $response = $this->send_request('POST', $url, $this->api_key, $post_data);

        return $response;
    }

    public function  update_help($id, $post_data)
    {
        $url = $this->api_url . '/api/helps/' . $id;
        $response = $this->send_request('PUT', $url, $this->api_key, $post_data);

        return $response;
    }

    public function delete_help($id)
    {
        $url = $this->api_url . '/api/helps/' . $id;
        $response = $this->send_request('DELETE', $url, $this->api_key);

        return $response;
    }

    /**
     * PARTNERS
     */
    public function get_partners()
    {
        $url = $this->api_url . '/api/partners';
        $response = $this->send_request('GET', $url, $this->api_key);

        return $response;
    }

    public function get_partner($id)
    {
        $url = $this->api_url . '/api/partners/' . $id;
        $response = $this->send_request('GET', $url, $this->api_key);

        return $response;
    }

    public function create_partner($post_data)
    {
        $url = $this->api_url . '/api/partners';
        $response = $this->send_request('POST', $url, $this->api_key, $post_data);

        return $response;
    }


    public function update_partner($id, $post_data)
    {
        $url = $this->api_url . '/api/partners/' . $id;
        $response = $this->send_request('PUT', $url, $this->api_key, $post_data);

        return $response;
    }

    public function delete_partner($id)
    {
        $url = $this->api_url . '/api/partners/' . $id;
        $response = $this->send_request('DELETE', $url, $this->api_key);

        return $response;
    }

    protected function send_request($method, $url, $api_key = null, $data = null)
    {
        try {
            $client = new \GuzzleHttp\Client();

            $headers = [
                'Content-Type' => 'application/json'
            ];

            if ($api_key) {
                $headers['Authorization'] = 'Bearer ' . $api_key;
            }

            $response = $client->request($method, $url, [
                'headers' => $headers,
                'body' => $data
            ]);

            $response = $response->getBody()->getContents();

            return json_decode($response);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
