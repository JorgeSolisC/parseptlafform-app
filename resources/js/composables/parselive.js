import Parse from 'parse/dist/parse.min.js';


Parse.initialize("MiSuperApp123", "MiMasterKey456");
Parse.serverURL = "http://localhost:1337/parse";
Parse.liveQueryServerURL = "ws://localhost:1337/parse"; 

// Habilita LiveQuery
const YourClass = Parse.Object.extend("User");
const query = new Parse.Query(YourClass);
export async function useParseEvent() {
    try {
      const subscription = await query.subscribe();
      return subscription;
    } catch (error) {
      console.error('Error al suscribirse a LiveQuery:', error);
      throw error;
    }
  }
