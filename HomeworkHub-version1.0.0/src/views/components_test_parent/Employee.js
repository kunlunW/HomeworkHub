import {useContext, useState, useEffect} from 'react';



const Employee = (props) => {

    const [show, setShow] = useState(false);
    
    const handleShow = () => setShow(true);
    const handleClose = () => setShow(false);

    useEffect(() => {
        handleClose()
    }, [props.employee])

    return (
        <>
            <td>{props.employee.name}</td>
            <td>{props.employee.description}</td>
            <td>{props.employee.duedate}</td>
            <td>{props.employee.timelimit}</td>
            <td>{props.employee.points}</td>
            <td>
                            
            </td>
        </>
    )
}

export default Employee;