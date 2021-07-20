import axios from 'axios'
import ImportTax from './ImportTax'

async function importPost(e) {
    let wordpressData = e.wordpressData
    let fieldsProps = Object.getOwnPropertyNames(wordpressData.fields)

    fieldsProps.forEach(prop => {
        if(prop != 'id') {
            if(wordpressData.fields[prop] === undefined) {
                wordpressData.fields[prop] = '';
            }
        }
    })

    
    let endpoint
    let headers = {
        //'X-WP-Nonce': wpApiSettings.nonce, We not use official WP Rest API
        "Content-Type": "application/json",
        "cache-control": "no-cache",
    }

    if(wordpressData.idPost !== undefined) {
        endpoint = '/?rest_api=true&endpoint=point-of-sales&post='+wordpressData.idPost;
    } else {
        endpoint = '/?rest_api=true&endpoint=point-of-sales'
    }

    /** 
     * Fetch Taxonomies
     * 
     * This procedure is deprecated becouse this move to /point-of-sale endpoint
     * 
     */
    /*
    let value

    if(wordpressData.miasto !== undefined) {
        wordpressData.miasto = wordpressData.miasto.split(',').map(item => item.trim());
        value = await ImportTax(wordpressData.miasto, 'miasto')
        wordpressData.miasto = value
    }

    if(wordpressData.certyfikat !== undefined) {
        wordpressData.certyfikat = wordpressData.certyfikat.split(',').map(item => item.trim());
        value = await ImportTax(wordpressData.certyfikat, 'certyfikat')
        wordpressData.certyfikat = value
    
    }

    if(wordpressData.typ_placowki !== undefined) {
        wordpressData.typ_placowki = wordpressData.typ_placowki.split(',').map(item => item.trim());
        value = await ImportTax(wordpressData.typ_placowki, 'typ_placowki')
        wordpressData.typ_placowki = value
    }
    
    if(wordpressData.typ_oferty !== undefined) {
        wordpressData.typ_oferty = wordpressData.typ_oferty.split(',').map(item => item.trim());
        value = await ImportTax(wordpressData.typ_oferty, 'typ_oferty')
        wordpressData.typ_oferty = value
    }

    console.log(wordpressData);
    */

    /**
     * Post post
     */
    try {
        await axios({ 
            method: 'post', 
            url: endpoint, 
            headers: headers, 
            data: wordpressData 
        })
    } catch (err) {
        if(err.response.data.code === "rest_post_invalid_id") { 
            try {
                endpoint = '/?rest_api=true&endpoint=point-of-sales'
                await axios({ 
                    method: 'post', 
                    url: endpoint, 
                    headers: headers, 
                    data: wordpressData 
                })
            } catch (err) {
                console.log(err)
            }

        } else {
            console.log(err)
        }
    }
    return e
}
export default importPost