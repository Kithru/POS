package lk.ijse.spring.repo;

import lk.ijse.spring.entity.OrderDetails;
import org.springframework.data.jpa.repository.JpaRepository;

/**
 * @author : Kithru Viduranga
 * @project : SpringBoot-POS
 **/
public interface OrderDetailsRepo extends JpaRepository<OrderDetails, String> {
}

// KV