--
-- Table structure for table `orderslist`
--

CREATE TABLE `orderslist` (
  `id` bigint(255) NOT NULL,
  `sku_id` bigint(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 is for active, 0 is for inactive',
  `quantity` int(100) NOT NULL,
  `width` int(100) NOT NULL,
  `height` int(100) NOT NULL,
  `totalPrice` bigint(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sku`
--

CREATE TABLE `sku` (
  `id` bigint(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 is for active, 0 is for inactive',
  `sku_name` varchar(100) NOT NULL,
  `pricepercm` bigint(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderslist`
--
ALTER TABLE `orderslist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sku`
--
ALTER TABLE `sku`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderslist`
--
ALTER TABLE `orderslist`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sku`
--
ALTER TABLE `sku`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;