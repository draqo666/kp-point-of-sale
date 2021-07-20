/**
 * 
 * Deprecated
 * 
 */


import axios from 'axios'
let headers = {
    //'X-WP-Nonce': wpApiSettings.nonce, We not use official WP Rest API
    "Content-Type": "application/json",
    "cache-control": "no-cache",
}

const getQuery = (item, endpoint) => {
    return {
        method: 'post',
        url: endpoint,
        headers: headers,
        data: {
            name: item
        }
    }
}

async function importTax(item, type) {
    let endpoint

    if(type === 'miasto') {
        endpoint = '/?rest_api=true&endpoint=point-of-sales/miasto'
    } else if (type === 'certyfikat') {
        endpoint = '/?rest_api=true&endpoint=point-of-sales/certyfikat'
    } else if (type === 'typ_placowki') {
        endpoint = '/?rest_api=true&endpoint=point-of-sales/typ_placowki'
    } else if (type === 'typ_oferty') {
        endpoint = '/?rest_api=true&endpoint=point-of-sales/typ_oferty'
    }
    console.log(item);
    return await Promise.all(item.map(async item => {
        try {
            return await axios(getQuery(item, endpoint)).then(resp => {
                return resp.data.id
            })
        } catch (e) {
            if(e.response.data.code === 'term_exists') {
                return e.response.data.data.term_id
            } else {
                console.log(e.response)
            }
        }
    }))

}
export default importTax