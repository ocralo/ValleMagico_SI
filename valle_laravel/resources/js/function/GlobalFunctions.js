
export async function fetchApi(url) {

  const res = await fetch(url).then()
  let result = await res.json();
  return result

}


export async function fetchPOST(url, dataJson, typeFetch) {
  let prueba;
  const contentMeta = getToken();
console.log(url, dataJson);
  await fetch(url, {
    method: typeFetch, // or 'PUT'
    body: JSON.stringify(dataJson), // data can be `string` or {object}!
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': contentMeta
    }
  }).then(result => {
      console.log("TCL: fetchPOST -> result", result)
      prueba = result.status;
      return prueba;
}).then( prueba => { return true})
.catch((err) => { return err })

}

export async function fetchPost(url, dataJson) {
  const contentMeta = getToken();
  try {
    let result = await fetch(url, {
      method: 'POST',
      body: JSON.stringify(dataJson),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': contentMeta
      }
    })
    return result.json();
  } catch(err) {
    console.log(err);
  }
}

function getToken() {
  const metas = document.getElementsByTagName('meta');

  for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "csrf-token") {
      return metas[i].getAttribute('content');
    }
  }
}