package lk.ijse.spring.service.impl;

import lk.ijse.spring.dto.CustomDTO;
import lk.ijse.spring.dto.CustomerDTO;
import lk.ijse.spring.entity.Customer;
import lk.ijse.spring.repo.CustomerRepo;
import lk.ijse.spring.service.CustomerService;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.ArrayList;

/**
 * @author : Kithru Viduranga
 * @project : SpringBoot-POS
 **/
@Service
@Transactional
public class CustomerServiceImpl implements CustomerService {

    @Autowired
    private CustomerRepo repo;
    @Autowired
    private ModelMapper mapper;

    @Override
    public void saveCustomer(CustomerDTO dto) {
        if (repo.existsById(dto.getId())) {
            throw new RuntimeException("Customer Already Exist...! Please Enter Another ID");
        }
        repo.save(mapper.map(dto, Customer.class));
    }

    @Override
    public CustomerDTO searchCusId(String id) {
        if (!repo.existsById(id)) {
            throw new RuntimeException("Wrong ID. Please Enter Valid ID");
        }
        return mapper.map(repo.findById(id).get(), CustomerDTO.class);
    }

    @Override
    public void updateCustomer(CustomerDTO dto) {
        if (!repo.existsById(dto.getId())) {
            throw new RuntimeException("Customer Not Exist...! Please Enter Valid ID");
        }
        repo.save(mapper.map(dto, Customer.class));
    }

    @Override
    public void deleteCustomer(String id) {
        if (!repo.existsById(id)) {
            throw new RuntimeException("Wrong ID...! Please Enter Valid ID");
        }
        repo.deleteById(id);
    }

    @Override
    public ArrayList<CustomerDTO> loadAllCustomer() {
        return mapper.map(repo.findAll(), new TypeToken<ArrayList<Customer>>() {
        }.getType());
    }

    @Override
    public CustomDTO customerIdGenerate() {
        return new CustomDTO(repo.getLastIndex());
    }

    @Override
    public CustomDTO getSumCustomer() {
        return new CustomDTO(repo.getSumCustomer());
    }
}