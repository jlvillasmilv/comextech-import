export default {
	namespaced: true,
    state: {
    	exchangeItem: [
                {
                    id: 1,
                    name: "A. pago proveedor",
                    date: new Date().toISOString(),
                    currency: "CNY",
                    amo: 455000,
                    amo2: 6000000
                },
                {
                    id: 2,
                    name: "A.1 ADELANTO",
                    date: new Date().toISOString(),
                    currency: "CNY",
                    amo: 455000,
                    amo2: 6000000
                },
                {
                    id: 3,
                    name: "A.2 SALDO",
                    date: new Date().toISOString(),
                    currency: "CNY",
                    amo: 330000,
                    amo2: 4000000
                },
                {
                    id: 4,
                    name: "B.- Transporte Internacional",
                    date: new Date().toISOString(),
                    currency: "USD",
                    amo: 4000,
                    amo2: 3000000
                },
                {
                    id: 5,
                    name: "C.- Seguro Transporte",
                    date: new Date().toISOString(),
                    currency: "USD",
                    amo: 300,
                    amo2: 210000
                },
                {
                    id: 6,
                    name: "D.- Servicio AGA",
                    date: new Date().toISOString(),
                    currency: "CLP",
                    amo: 250,
                    amo2: 250
                },
                {
                    id: 7,
                    name: "E.- IVA Internacion",
                    date: new Date().toISOString(),
                    currency: "CLP",
                    amo: 2000000,
                    amo2: 2000000
                },
                {
                    id: 8,
                    name: "F.- Aranceles",
                    date: new Date().toISOString(),
                    currency: "CLP",
                    amo: 1000000,
                    amo2: 1000000
                },
                {
                    id: 9,
                    name: "F.- Transporte Local",
                    date: new Date().toISOString(),
                    currency: "CLP",
                    amo: 300000,
                    amo2: 300000
                },
            ]
        
    },
  
    getters: {
     
    },
  
    mutations: {
        updateItem(state, payload) {

           payload.exchangeItem.forEach(e => {
                try {
                   //Find index of specific object using findIndex method.    
                   let objIndex = state.exchangeItem.findIndex((obj => obj.id == e.id));
                    
                   //Update object's name property.
                    state.exchangeItem[objIndex].amo       = payload.amo;
                    state.exchangeItem[objIndex].date      = payload.date;
                    state.exchangeItem[objIndex].currency  = payload.currency;

                } catch (err) {
                    // Handle Error Here
                    console.error(err);
                }


            });
        }
    },
  
    actions: {
       
    },
  }