window.onload = () => {
    const filterForm = document.querySelector("#categories-filter");
    document.querySelectorAll("#categories-filter input").forEach(input =>{
        input.addEventListener('change', () => {
            const Form = new FormData(filterForm);

            const Params = new URLSearchParams;

            Form.forEach((value, key) => {
                Params.append(key, value);
            });
            const Url = new URL(window.location.href);
            
            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1",{
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                    response.json()
            ).then(data =>{
                const content = document.querySelector("#content");
                console.log(content);
                content.innerHTML = data.content;
            }).catch(e => alert(e))
        })
    }) 
}