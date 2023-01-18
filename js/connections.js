export function sendCardQuery(query) {
    let request = new XMLHttpRequest();
    let data = new FormData();
    data.append('__PULL', '1');
    data.append('__CARD', '1');
    data.append('__QUERY', query);

    request.open('POST', './pub.php');
    setTimeout(function(e) { request.send(data) }, 2000);
    

    let promise = new Promise((resolve, reject) => 
    {
        request.onreadystatechange = function(e) {
            if ( request.status == 200 && request.readyState == 4 ){
                resolve(request.response);
            }
        }
        request.onerror = function(e) {
            reject('Error!');
        }

    });

    return promise;
}