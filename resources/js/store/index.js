
export default {

	state: {
		categorySelected:null,
		productHidden: false,
		categoriesHidden: true,
		categoryAtributes: null,
		searchArray: null,
		mlAttributes: null,
		userProfile: null,
	},

	actions: {
		async categorySelect({commit}, category){
			const datos = await axios.get('mlcategory/' + category)
			commit('catSelect', datos.data)
		},
		toggleCategories({commit},toggle){
			commit('toggleCat',toggle)
		},
		toggleProduct({commit},toggle){
			commit('toggleProd',toggle)
		},
		async getAttributes({commit},payload){
			// let category = await payload.category
			// let array = payload.array
			
			try {
				const datos = await axios.get('categoryatributes/' + payload.category)      
				const attributes = datos.data.groups[0].components
				let array = []
				/*-- Crea un array adicional para subir atributos a Mercadolibre --*/
				attributes.forEach(element => {
					if (element.attributes[0].name =="Marca") {
						array.push({id: element.attributes[0].id, name: element.attributes[0].name, value_name: payload.array.brand})	
					}else{
					array.push({id: element.attributes[0].id, name: element.attributes[0].name, value_name:null})	
				}
				});
				console.log(array)
				commit('getAttr', {attributes:attributes, mlArray:array})
			} catch (error) {
			}
		},
		setSearchArray({commit}, array){
			commit('setSearchArr', array)
		},
		async getUserProfile({commit}){
			const datos = await axios.get('profile')
			commit('getUserInfo', datos)
		},		
	},

	mutations: {
		catSelect(state, category){
			state.categorySelected = {id:category.id, name:category.name, path:category.path_from_root}
		},
		toggleCat(state, toggle){
			state.categoriesHidden = toggle
		},
		toggleProd(state, toggle){
			state.productHidden = toggle
		},
		getAttr(state, payload){
			state.mlAttributes = payload.mlArray
			state.categoryAtributes = payload.attributes
			console.log(state.mlAttributes)
		},
		setSearchArr(state,array){
			state.searchArray = array
		},
		getUserInfo(state,array){
			state.userProfile = array
		}
    }
}
