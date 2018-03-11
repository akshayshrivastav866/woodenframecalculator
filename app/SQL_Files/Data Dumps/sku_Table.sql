INSERT INTO `sku` (`id`, `status`, `sku_name`, `pricepercm`, `created`, `modified`) VALUES
(1, 1, 'demo 1', 40, '2018-03-09 18:18:06', '2018-03-09 18:18:06'),
(2, 1, 'demo 2', 20, '2018-03-09 18:21:18', '2018-03-09 18:21:18'),
(3, 1, 'demo 3', 10, '2018-03-09 18:21:18', '2018-03-09 18:21:18');

-- AUTO_INCREMENT for table `sku`
--
ALTER TABLE `sku`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;