import Vue from 'vue'
import VueIdb from 'vue-idb'
Vue.use(VueIdb)

const idb = new VueIdb({
  version: 1,
  database: 'dbwih',
  schemas: [
    { schemawih: 'id, clave, valor' }
  ]
})
class GStoreIDB {
  addItem = function (item) {
    var db
    var request =  indexedDB.open("dbwih")
    request.onerror = function(event) {
      console.log(event)
      alert("Why didn't you allow my web app to use IndexedDB?!")
    }
    request.onsuccess = function(event) {
      db = request.result
      var transaction = db.transaction(["schemawih"], "readwrite")
      var objectStore = transaction.objectStore("schemawih")
      var addRequest = objectStore.add(item)
    }
  }

  getItem_ = function (clave) {
    var db
    var x
    var request =  indexedDB.open("dbwih")
    request.onerror = function(event) {
      console.log(event)
      alert("Why didn't you allow my web app to use IndexedDB?!")
    }
    request.onsuccess = function(event) {
      db = request.result
      var transaction = db.transaction(["schemawih"], "readonly")
      var objectStore = transaction.objectStore("schemawih")
      var index = objectStore.index('clave')
      console.log(index)
      index.get(clave).onsuccess = function(event) {
        return event.target.result
        console.log(x)
      }
    }
  }
  getItem = async function (){
    var db
    return new Promise(function(resolve, reject){
      var request =  indexedDB.open("dbwih")
      request.onsuccess = function(){
        db = request.result
        var transaction = db.transaction(["schemawih"], "readonly")
        var objectStore = transaction.objectStore("schemawih")
        var index = objectStore.index('clave')
        console.log(index)
        index.get(1).onsuccess = function(event) {
          resolve(event.target.result)
        }
        
      }
    })
  }


  deleteItem = function (id) {
    var db
    var request =  indexedDB.open("dbwih")
    request.onerror = function(event) {
      console.log(event)
      alert("Why didn't you allow my web app to use IndexedDB?!")
    }
    request.onsuccess = function(event) {
      db = request.result
      var transaction = db.transaction(["schemawih"], "readwrite")
      var objectStore = transaction.objectStore("schemawih")
      objectStore.delete(id)
    }
  }
}

export default GStoreIDB
