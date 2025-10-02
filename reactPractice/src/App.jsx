import React , { useReducer , useEffect , useRef ,useState } from 'react'
import './App.css'

//user reducer is a hook,which offers a predictable way to manage comples state logic
//within a React Component.In this tutorial , we will explore the code example provided and
//explain each concept in detail to help beginner developers understand useReducer hook.
//importing useReducer from the react module allow us to use the useReducer hook in our company
//initialState represents the initial value of the state,which in this case is set to 0
const intitialState = 0;
function App() {

    const [state,dispatch]              = useReducer(reducer,intitialState);
    const [count,setCount]              = useState(0);
    const [todos,setTodos]                = useState([]);
    const contactRef          = useRef(0);
    function reducer(state,action) {

        switch (action.type) {

            case "increment" :
                return state + 1;

            case "decrement" :
                return state - 1;

            case "division"  :
                return state / 2;

            case "multiply"  :
                return state * 2;

            default          :
                throw new Error();
        }
    }
    
    useEffect( () => {
        
    },[]);

    return (
        <>
            <div>Hello count : {state}</div>
            <button
            onClick = { () => dispatch({
                type : "increment"
            }) }
            >+</button>
            <button
            onClick = { () => dispatch({
                type : "decrement"
            }) }
            >-</button>
            <button
            onClick = { () => dispatch({
                type : "division"
            }) }
            >/</button>
            <button
            onClick = { () => dispatch({
                type : "multiply"
            }) }
            >*</button>
        </>
    )
}

export default App
