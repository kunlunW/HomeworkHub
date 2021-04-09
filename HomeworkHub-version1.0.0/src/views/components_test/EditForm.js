import { Form, Button } from "react-bootstrap"

import {EmployeeContext} from '../contexts_test/EmployeeContext';
import {useContext, useState} from 'react';

const EditForm = ({theEmployee}) =>{

    const id = theEmployee.id;

    const [name, setName] = useState(theEmployee.name);
    const [time, setEmail] = useState(theEmployee.time);
    const [limit, setAddress] = useState(theEmployee.limit);
    const [points, setPhone] = useState(theEmployee.points);


    const {updateEmployee} = useContext(EmployeeContext);

    const updatedEmployee = {id, name, time, limit, points}

    const handleSubmit = (e) => {
        e.preventDefault();
        updateEmployee(id, updatedEmployee)
    }

     return (

        <Form onSubmit={handleSubmit}>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Name *"
                    name="name"
                    value={name}
                    onChange={(e)=> setName(e.target.value)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Due Time *"
                    name="time"
                    value={time}
                    onChange={(e)=> setEmail(e.target.value)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Time Limit *"
                    name="limit"
                    value={limit}
                    onChange={(e)=> setAddress(e.target.value)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Total Points"
                    name="points"
                    value={points}
                    onChange={(e)=> setPhone(e.target.value)}
                    // required
                />
            </Form.Group>
            <Button variant="success" type="submit" block>
                Edit Test
            </Button>
        </Form>

     )
}

export default EditForm;
