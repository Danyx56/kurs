const contentTabs=document.querySelectorAll('.tab-content');
const workPrincsUrl=`http://localhost/php/kurs/api/WorkPrincs`;
const workPrincsTableBody=document.querySelector('#workPrincTable tbody');
const workPrincsForm=document.getElementById('workPrincForm');
const spheresOfApplUrl=`http://localhost/php/kurs/api/SpheresOfAppl`;
const spheresOfApplTableBody=document.querySelector('#sphereOfApplTable tbody');
const spheresOfApplForm=document.getElementById('sphereOfApplForm');
const propertiesUrl=`http://localhost/php/kurs/api/Properties`;
const propertiesTableBody=document.querySelector('#propertyTable tbody');
const propertiesForm=document.getElementById('propertyForm');
const infraHeatersUrl=`http://localhost/php/kurs/api/Heaters`;
const infraHeatersTableBody=document.querySelector('#infraHeaterTable tbody');
const infraHeatersForm=document.getElementById('infraHeaterForm');
const loginForm=document.getElementById('loginForm');
const workPrincDropdown=document.querySelector('#infraHeaterForm select[name="workprincid"]');
const sphereOfApplDropdown=document.querySelector('#infraHeaterForm select[name="sphereofapplid"]');
const profileUrl=`http://localhost/php/kurs/api/Profile`;
const searchForm=document.getElementById('searchForm');
function getLoginInfo(){
    fetch(profileUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if(!data.login){
            document.getElementById('loginContainer').style.display='block';
            document.getElementById('contentContainer').style.display='none';
        } else{
            document.getElementById('loginContainer').style.display='none';
            document.getElementById('contentContainer').style.display='block';
            displayWorkPrincs();
            displaySpheresOfAppl();
            displayProperties();
            displayInfraHeaters('');
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function showContentTab(target){
    for(let i=0;i<contentTabs.length;i++){
        contentTabs[i].style.display='none';
    }
    document.querySelector(target).style.display='block';
}
showContentTab('#workPrincContent');
function displayWorkPrincs(){
    fetch(workPrincsUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let workPrincs=data.workPrincs;
        let content=``;
        let dropDownOptions=``;
        for (let i=0;i<workPrincs.length;i++){
            dropDownOptions+=`<option value="${workPrincs[i].id}">${workPrincs[i].name}</option>`;
            content+=`<tr>
                    <td>${workPrincs[i].id}</td>
                    <td>${workPrincs[i].name}</td>
                    <td>
                        <a class="btn btn-warning edit-workPrinc-btn" data-id="${workPrincs[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-workPrinc-btn" data-id="${workPrincs[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        workPrincDropdown.innerHTML=dropDownOptions;
        workPrincsTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function displaySpheresOfAppl(){
    fetch(spheresOfApplUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let spheresOfAppl=data.spheresOfAppl;
        let content=``;
        let dropDownOptions=``;
        for (let i=0;i<spheresOfAppl.length;i++){
            dropDownOptions+=`<option value="${spheresOfAppl[i].id}">${spheresOfAppl[i].name}</option>`;
            content+=`<tr>
                    <td>${spheresOfAppl[i].id}</td>
                    <td>${spheresOfAppl[i].name}</td>
                    <td>
                        <a class="btn btn-warning edit-sphereOfAppl-btn" data-id="${spheresOfAppl[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-sphereOfAppl-btn" data-id="${spheresOfAppl[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        sphereOfApplDropdown.innerHTML=dropDownOptions;
        spheresOfApplTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function displayProperties(){
    fetch(propertiesUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let properties=data.properties;
        let content=``;
        let inputsContent=``;
        for (let i=0;i<properties.length;i++){
            content+=`<tr>
                    <td>${properties[i].id}</td>
                    <td>${properties[i].name}</td>
                    <td>${properties[i].units}</td>
                    <td>
                        <a class="btn btn-warning edit-property-btn" data-id="${properties[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-property-btn" data-id="${properties[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
            inputsContent+=`<p>
            <input type="text" class="form-control prop-input" required placeholder="${properties[i].name} ${properties[i].units}" name="prop_${properties[i].id}"/>
            </p>`
        }
        propertiesTableBody.innerHTML=content;
        document.getElementById('propertiesInputContainer').innerHTML=inputsContent;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function displayInfraHeaters(search){
    let url=infraHeatersUrl;
    if(search!=''){
        url+='?search='+search;
    }
    fetch(url)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let infraHeaters=data.infraHeaters;
        let content=``;
        for (let i=0;i<infraHeaters.length;i++){
            let propertiesContent=``;
            for (j=0;j<infraHeaters[i].properties.length;j++){
                propertiesContent+=`
                ${infraHeaters[i].properties[j].name}: ${infraHeaters[i].properties[j].value} ${infraHeaters[i].properties[j].units} </br>
                `
            }
            content+=`<tr>
                    <td>${infraHeaters[i].id}</td>
                    <td>${infraHeaters[i].vendor}</td>
                    <td>${infraHeaters[i].model}</td>
                    <td>${infraHeaters[i].workPrincname}</td>
                    <td>${infraHeaters[i].sphereOfApplname}</td>
                    <td>${infraHeaters[i].price}</td>
                    <td>${propertiesContent}</td>
                    <td>
                        <a class="btn btn-warning edit-infraHeater-btn" data-id="${infraHeaters[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-infraHeater-btn" data-id="${infraHeaters[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        infraHeatersTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
searchForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        displayInfraHeaters(document.querySelector('#searchForm input[name="search"]').value);
        searchForm.reset();
    });
 workPrincsForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            name: document.querySelector('#workPrincForm input[name="name"]').value,
            id:document.querySelector('#workPrincForm input[name="id"]').value
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(workPrincsUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            workPrincsForm.reset();
            document.querySelector('#workPrincForm input[name="id"]').value='';
            displayWorkPrincs();
        });

    });
    loginForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            login: document.querySelector('#loginForm input[name="login"]').value,
            password:document.querySelector('#loginForm input[name="password"]').value
        };
        let options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        fetch(profileUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
            })
            .then(data => {
                if(!data.login){
                    document.getElementById('loginContainer').style.display='block';
                    document.getElementById('contentContainer').style.display='none';
                    document.getElementById('loginError').innerHTML='Неправильний логін або пароль';
                } else{
                    document.getElementById('loginContainer').style.display='none';
                    document.getElementById('contentContainer').style.display='block';
                    document.getElementById('loginError').innerHTML='';
                    displayWorkPrincs();
                    displaySpheresOfAppl();
                    displayProperties();
                    displayInfraHeaters('');
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });
    spheresOfApplForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            name: document.querySelector('#sphereOfApplForm input[name="name"]').value,
            id:document.querySelector('#sphereOfApplForm input[name="id"]').value
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(spheresOfApplUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            spheresOfApplForm.reset();
            document.querySelector('#sphereOfApplForm input[name="id"]').value='';
            displaySpheresOfAppl();
        });

    });
     propertiesForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            units: document.querySelector('#propertyForm input[name="units"]').value,
            name: document.querySelector('#propertyForm input[name="name"]').value,
            id:document.querySelector('#propertyForm input[name="id"]').value
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(propertiesUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            propertiesForm.reset();
            document.querySelector('#propertyForm input[name="id"]').value='';
            displayProperties();
        });

    });
    infraHeatersForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        let propInputs=document.querySelectorAll('.prop-input');
        let inputValuesArray=[];
        for(let i=0;i<propInputs.length;i++){
            inputValuesArray[propInputs[i].getAttribute('name')]=propInputs[i].value;
        }
        const dataToSend = {
            vendor: document.querySelector('#infraHeaterForm input[name="vendor"]').value,
            model: document.querySelector('#infraHeaterForm input[name="model"]').value,
            price:document.querySelector('#infraHeaterForm input[name="price"]').value,
            workprincid: document.querySelector('#infraHeaterForm select[name="workprincid"]').value,
            sphereofapplid: document.querySelector('#infraHeaterForm select[name="sphereofapplid"]').value,
            id:document.querySelector('#infraHeaterForm input[name="id"]').value,
            ...inputValuesArray
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(infraHeatersUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            infraHeatersForm.reset();
            document.querySelector('#infraHeaterForm input[name="id"]').value='';
            displayInfraHeaters('');
        });

    });
document.addEventListener('click', function(event) {
  if (event.target.classList.contains('delete-workPrinc-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(workPrincsUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displayWorkPrincs();
        });    
  } else if (event.target.classList.contains('edit-workPrinc-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(workPrincsUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let workPrinc=data;
            document.querySelector('#workPrincForm input[name="name"]').value=workPrinc.name,
            document.querySelector('#workPrincForm input[name="id"]').value=workPrinc.id
        });    
  } else if (event.target.classList.contains('delete-sphereOfAppl-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(spheresOfApplUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displaySpheresOfAppl();
        });    
  } else if (event.target.classList.contains('edit-sphereOfAppl-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(spheresOfApplUrl +`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let sphereOfAppl=data;
            document.querySelector('#sphereOfApplForm input[name="name"]').value=sphereOfAppl.name,
            document.querySelector('#sphereOfApplForm input[name="id"]').value=sphereOfAppl.id
        });    
  }else if (event.target.classList.contains('delete-property-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(propertiesUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displayProperties();
        });    
  } else if (event.target.classList.contains('edit-property-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(propertiesUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let property=data;
            document.querySelector('#propertyForm input[name="units"]').value=property.units,
            document.querySelector('#propertyForm input[name="name"]').value=property.name,
            document.querySelector('#propertyForm input[name="id"]').value=property.id
        });    
  } else if (event.target.classList.contains('delete-infraHeater-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(infraHeatersUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displayInfraHeaters('');
        });    
  } else if (event.target.classList.contains('edit-infraHeater-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(infraHeatersUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let infraHeater=data;
            document.querySelector('#infraHeaterForm input[name="model"]').value=infraHeater.model,
            document.querySelector('#infraHeaterForm input[name="vendor"]').value=infraHeater.vendor,
            document.querySelector('#infraHeaterForm select[name="workprincid"]').value=infraHeater.workPrincid,
            document.querySelector('#infraHeaterForm select[name="sphereofapplid"]').value=infraHeater.sphereOfApplid,
            document.querySelector('#infraHeaterForm input[name="price"]').value=infraHeater.price,
            document.querySelector('#infraHeaterForm input[name="id"]').value=infraHeater.id;
            for (let i=0;i<infraHeater.properties.length;i++){
                document.querySelector('#infraHeaterForm input[name="prop_'+infraHeater.properties[i].propertyid+'"]').value=infraHeater.properties[i].value;
            }
        });    
  }
   else if (event.target.classList.contains('nav-btn')) {
    event.preventDefault();
    if(event.target.id=='logoutBtn'){
        fetch(profileUrl+'?action=logout')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            getLoginInfo();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    } else{
        showContentTab(event.target.getAttribute('data-target'));
    }
  }
});    
getLoginInfo();