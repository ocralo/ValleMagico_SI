export async function fetchApi(url) {
    return await fetch(url)
        .then(res => res.json())
        .catch(err => {
            if (err.name === "AbortError") {
                //console.log("Fetch aborted");
            } else {
                console.error("Uh oh, an error!", err);
            }
        });
}

export async function fetchPOST(url, dataJson, typeFetch) {
    let prueba;
    const contentMeta = getToken();
    //console.log(url, dataJson);
    await fetch(url, {
        method: typeFetch, // or 'PUT'
        body: JSON.stringify(dataJson), // data can be `string` or {object}!
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": contentMeta
        }
    })
        .then(result => {
            //console.log("TCL: fetchPOST -> result", result);
            prueba = result.status;
            return prueba;
        })
        .then(prueba => {
            return true;
        })
        .catch(err => {
            return err;
        });
}

export async function fetchPost(url, dataJson) {
    const contentMeta = getToken();
    try {
        let result = await fetch(url, {
            method: "POST",
            body: JSON.stringify(dataJson),
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": contentMeta
            }
        });
        return result.json();
    } catch (err) {
        //console.log(err);
    }
}

export async function download(url, dataJson, method, filename) {
    const contentMeta = getToken();
    const res = await fetch(url, {
        method: method, // or 'PUT'
        body: JSON.stringify(dataJson), // data can be `string` or {object}!
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": contentMeta
        }
    });
    const blob = await res.blob();
    const urlObj = window.URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = urlObj;
    a.download = filename;
    document.body.appendChild(a); // we need to append the element to the dom -> otherwise it will not work in firefox
    a.click();
    a.remove(); //afterwards we remove the element again
}

function getToken() {
    const metas = document.getElementsByTagName("meta");

    for (let i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute("name") === "csrf-token") {
            return metas[i].getAttribute("content");
        }
    }
}
