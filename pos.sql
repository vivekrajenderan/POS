-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 23, 2018 at 05:11 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `a_sokxay`
--

-- --------------------------------------------------------

--
-- Table structure for table `ospos_account`
--

CREATE TABLE `ospos_account` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_account`
--

INSERT INTO `ospos_account` (`id`, `name`, `parent`, `text`, `employee_id`) VALUES
(1, 'Assets', 0, '', 1),
(2, 'Liabilities', 0, '', 1),
(3, 'Owners Equity', 0, '', 1),
(4, 'Retained Earnings', 0, '', 1),
(5, 'Expenses', 0, '', 1),
(6, 'Accounts Receivable', 1, '', 1),
(7, 'Advance Tax', 1, '', 1),
(8, 'Furniture and Equipment', 1, '', 1),
(9, 'Inventory Asset', 1, '', 1),
(10, 'Accounts Payable', 2, '', 1),
(11, 'Tax Payable', 2, '', 1),
(12, 'Bank', 2, '', 1),
(13, 'Debit Card', 2, '', 1),
(14, 'Credit Card', 2, '', 1),
(15, 'Check', 2, '', 1),
(16, 'Employees at hand', 2, '', 1),
(17, 'Other Liability', 2, '', 1),
(18, 'Goods In Transit', 1, '', 1),
(19, 'Cash', 1, '', 1),
(20, 'Petty Cash', 19, '', 1),
(21, 'Undeposited Funds', 19, '', 1),
(22, 'Investment', 3, '', 1),
(23, 'Opening Balance', 3, '', 1),
(24, 'Shipping Charge', 4, '', 1),
(25, 'Other Charges', 4, '', 1),
(26, 'Discount', 4, '', 1),
(27, 'Interest Income', 4, '', 1),
(28, 'General Income', 4, '', 1),
(29, 'Sales', 4, '', 1),
(30, 'Cost Of Goods Sold', 5, '', 1),
(31, 'Exchange Gain or Loss', 5, '', 1),
(32, 'Inventory Adjustment', 5, '', 1),
(33, 'Salaries and Employee Wages', 5, '', 1),
(34, 'Automobile Expense', 5, '', 1),
(35, 'Rent Expense', 5, '', 1),
(36, 'Janitorial', 5, '', 1),
(37, 'Postage', 5, '', 1),
(38, 'IT and Internet Expenses', 5, '', 1),
(39, 'Bad Debt', 5, '', 1),
(40, 'Printing and Stationery', 5, '', 1),
(41, 'Other Expenses', 5, '', 1),
(42, 'Repairs and Maintenance', 5, '', 1),
(43, 'Consultant Expense', 5, '', 1),
(44, 'Depreciation Expense', 5, '', 1),
(45, 'Telephone Expense', 5, '', 1),
(46, 'Travel Expense', 5, '', 1),
(47, 'Meals and Entertainment', 5, '', 1),
(48, 'Office Supplies', 5, '', 1),
(49, 'Advertising And Marketing', 5, '', 1),
(50, 'Credit Card Charges', 5, '', 1),
(51, 'Bank Fees and Charges', 5, '', 1),
(52, 'Uncategorized', 5, '', 1),
(53, 'Super Admin', 16, '', 1),
(54, 'Smr  Testing', 16, '', 1),
(55, 'Karuppasamy Annachi', 30, 'VVR', 1),
(56, 'Thambi Annachi', 30, 'MNR', 1),
(57, 'Senthil Kumar', 30, 'SLS', 1),
(58, 'Karuppasamy Annachi', 30, 'BILL 0004', 1),
(59, 'Kel Alders', 30, '9654546464', 1),
(60, 'Jerry Paton', 30, '8789797979', 1),
(61, 'Lance Regal', 30, '8932542525', 1),
(62, 'Mark Richardson', 30, '76813143555', 1),
(63, 'Carl Peters', 30, '897907097097', 1),
(64, 'Super Admin', 16, '', 1),
(65, 'Jennifer Gerth', 21, '', 1),
(66, ' ', 30, '', 1),
(67, ' ', 30, '', 1),
(68, 'David Joes', 16, '', 1),
(69, 'David Joes', 16, '', 1),
(70, 'David Joes', 16, '', 1),
(71, 'David Joes', 16, '', 1),
(72, 'David Joes', 16, '', 1),
(73, 'David Joes', 16, '', 1),
(74, 'David Joes', 16, '', 1),
(75, 'David Joes', 16, '', 1),
(76, 'David Joes', 16, '', 1),
(77, 'David Joes', 16, '', 1),
(78, 'David Joes', 16, '', 1),
(79, 'David Joes', 16, '', 1),
(80, 'David Joes', 16, '', 1),
(81, 'David Joes', 16, '', 1),
(82, 'David Joes', 16, '', 1),
(83, 'David Joes', 16, '', 1),
(84, 'David Joes', 16, '', 1),
(85, 'David Joes', 16, '', 1),
(86, 'John Deo', 16, '', 1),
(87, 'Lawarence Chan', 16, '', 1),
(88, 'James Byun', 16, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_account_trans`
--

CREATE TABLE `ospos_account_trans` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `trans_type` enum('debit','credit') NOT NULL DEFAULT 'credit',
  `amount` decimal(15,3) NOT NULL,
  `trans_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference` varchar(500) NOT NULL,
  `reference_type` varchar(500) DEFAULT NULL,
  `reference_table` varchar(100) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `url` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_account_trans`
--

INSERT INTO `ospos_account_trans` (`id`, `account_id`, `employee_id`, `location_id`, `trans_type`, `amount`, `trans_date`, `reference`, `reference_type`, `reference_table`, `reference_id`, `url`) VALUES
(1, 9, 1, 6, 'debit', '0.000', '2017-05-30 19:46:16', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/6'),
(2, 22, 1, 6, 'credit', '0.000', '2017-05-30 19:46:16', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/6'),
(3, 9, 1, 8, 'debit', '0.000', '2017-05-30 19:46:16', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/8'),
(4, 22, 1, 8, 'credit', '0.000', '2017-05-30 19:46:17', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/8'),
(5, 9, 1, 5, 'debit', '0.000', '2017-05-30 19:46:17', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/5'),
(6, 22, 1, 5, 'credit', '0.000', '2017-05-30 19:46:17', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/5'),
(7, 9, 1, 4, 'debit', '0.000', '2017-05-30 19:46:17', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/4'),
(8, 22, 1, 4, 'credit', '0.000', '2017-05-30 19:46:17', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/4'),
(9, 9, 1, 2, 'debit', '0.000', '2017-05-30 19:46:17', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/2'),
(10, 22, 1, 2, 'credit', '0.000', '2017-05-30 19:46:17', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/2'),
(11, 9, 1, 3, 'debit', '0.000', '2017-05-30 19:46:17', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/3'),
(12, 22, 1, 3, 'credit', '0.000', '2017-05-30 19:46:17', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/3'),
(13, 9, 1, 6, 'debit', '0.000', '2017-05-30 19:46:26', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/6'),
(14, 22, 1, 6, 'credit', '0.000', '2017-05-30 19:46:26', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/6'),
(15, 9, 1, 8, 'debit', '0.000', '2017-05-30 19:46:26', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/8'),
(16, 22, 1, 8, 'credit', '0.000', '2017-05-30 19:46:26', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/8'),
(17, 9, 1, 5, 'debit', '0.000', '2017-05-30 19:46:26', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/5'),
(18, 22, 1, 5, 'credit', '0.000', '2017-05-30 19:46:26', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/5'),
(19, 9, 1, 4, 'debit', '0.000', '2017-05-30 19:46:26', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/4'),
(20, 22, 1, 4, 'credit', '0.000', '2017-05-30 19:46:26', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/4'),
(21, 9, 1, 2, 'debit', '0.000', '2017-05-30 19:46:27', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/2'),
(22, 22, 1, 2, 'credit', '0.000', '2017-05-30 19:46:27', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/2'),
(23, 9, 1, 3, 'debit', '0.000', '2017-05-30 19:46:27', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/3'),
(24, 22, 1, 3, 'credit', '0.000', '2017-05-30 19:46:27', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/3'),
(25, 9, 1, 6, 'debit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/6'),
(26, 22, 1, 6, 'credit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/6'),
(27, 9, 1, 8, 'debit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/8'),
(28, 22, 1, 8, 'credit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/8'),
(29, 9, 1, 5, 'debit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/5'),
(30, 22, 1, 5, 'credit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/5'),
(31, 9, 1, 4, 'debit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/4'),
(32, 22, 1, 4, 'credit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/4'),
(33, 9, 1, 2, 'debit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/2'),
(34, 22, 1, 2, 'credit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/2'),
(35, 9, 1, 3, 'debit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/3'),
(36, 22, 1, 3, 'credit', '0.000', '2017-05-30 19:46:34', 'Manual Edit of Quantity', 'items_manually', 'items', 3, 'inventories/details3/3'),
(37, 9, 1, 6, 'debit', '0.000', '2017-05-30 19:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/6'),
(38, 22, 1, 6, 'credit', '0.000', '2017-05-30 19:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/6'),
(39, 9, 1, 8, 'debit', '0.000', '2017-05-30 19:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/8'),
(40, 22, 1, 8, 'credit', '0.000', '2017-05-30 19:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/8'),
(41, 9, 1, 5, 'debit', '0.000', '2017-05-30 19:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/5'),
(42, 22, 1, 5, 'credit', '0.000', '2017-05-30 19:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/5'),
(43, 9, 1, 4, 'debit', '0.000', '2017-05-30 19:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/4'),
(44, 22, 1, 4, 'credit', '0.000', '2017-05-30 19:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/4'),
(45, 9, 1, 2, 'debit', '0.000', '2017-05-30 19:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/2'),
(46, 22, 1, 2, 'credit', '0.000', '2017-05-30 19:46:43', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/2'),
(47, 9, 1, 3, 'debit', '0.000', '2017-05-30 19:46:43', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/3'),
(48, 22, 1, 3, 'credit', '0.000', '2017-05-30 19:46:43', 'Manual Edit of Quantity', 'items_manually', 'items', 4, 'inventories/details4/3'),
(49, 9, 1, 6, 'debit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/6'),
(50, 22, 1, 6, 'credit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/6'),
(51, 9, 1, 8, 'debit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/8'),
(52, 22, 1, 8, 'credit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/8'),
(53, 9, 1, 5, 'debit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/5'),
(54, 22, 1, 5, 'credit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/5'),
(55, 9, 1, 4, 'debit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/4'),
(56, 22, 1, 4, 'credit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/4'),
(57, 9, 1, 2, 'debit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/2'),
(58, 22, 1, 2, 'credit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/2'),
(59, 9, 1, 3, 'debit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/3'),
(60, 22, 1, 3, 'credit', '0.000', '2017-05-30 19:46:50', 'Manual Edit of Quantity', 'items_manually', 'items', 5, 'inventories/details5/3'),
(61, 9, 1, 6, 'debit', '0.000', '2017-05-30 19:49:02', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/6'),
(62, 22, 1, 6, 'credit', '0.000', '2017-05-30 19:49:03', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/6'),
(63, 9, 1, 8, 'debit', '0.000', '2017-05-30 19:49:03', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/8'),
(64, 22, 1, 8, 'credit', '0.000', '2017-05-30 19:49:03', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/8'),
(65, 9, 1, 5, 'debit', '0.000', '2017-05-30 19:49:03', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/5'),
(66, 22, 1, 5, 'credit', '0.000', '2017-05-30 19:49:04', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/5'),
(67, 9, 1, 4, 'debit', '0.000', '2017-05-30 19:49:04', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/4'),
(68, 22, 1, 4, 'credit', '0.000', '2017-05-30 19:49:04', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/4'),
(69, 9, 1, 2, 'debit', '0.000', '2017-05-30 19:49:04', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/2'),
(70, 22, 1, 2, 'credit', '0.000', '2017-05-30 19:49:04', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/2'),
(71, 9, 1, 3, 'debit', '0.000', '2017-05-30 19:49:04', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/3'),
(72, 22, 1, 3, 'credit', '0.000', '2017-05-30 19:49:04', 'Manual Edit of Quantity', 'items_manually', 'items', 6, 'inventories/details6/3'),
(73, 9, 7, 3, 'debit', '6714.000', '2017-05-30 19:52:32', 'BILL 0001', 'grn', 'receivings', 2, 'grn/receipt/2'),
(74, 10, 7, 3, 'credit', '6714.000', '2017-05-30 19:52:32', 'BILL 0001', 'grn', 'receivings', 2, 'grn/receipt/2'),
(75, 10, 7, 3, 'debit', '600.000', '2017-05-30 19:54:29', 'BILL 0001', 'bill', 'receivings', 2, 'grn/billreceipt/2'),
(76, 61, 7, 3, 'credit', '600.000', '2017-05-30 19:54:29', 'BILL 0001', 'bill', 'receivings', 2, 'grn/billreceipt/2'),
(77, 10, 7, 3, 'debit', '6114.000', '2017-05-30 19:55:18', 'BILL 0001', 'bill', 'receivings', 2, 'grn/billreceipt/2'),
(78, 61, 7, 3, 'credit', '6114.000', '2017-05-30 19:55:18', 'BILL 0001', 'bill', 'receivings', 2, 'grn/billreceipt/2'),
(79, 9, 7, 3, 'debit', '44091.000', '2017-05-30 19:56:09', 'BILL 0002', 'grn', 'receivings', 3, 'grn/receipt/3'),
(80, 10, 7, 3, 'credit', '44091.000', '2017-05-30 19:56:09', 'BILL 0002', 'grn', 'receivings', 3, 'grn/receipt/3'),
(81, 9, 7, 3, 'debit', '195.000', '2017-05-30 19:56:11', 'BILL 0003', 'grn', 'receivings', 4, 'grn/receipt/4'),
(82, 10, 7, 3, 'credit', '195.000', '2017-05-30 19:56:11', 'BILL 0003', 'grn', 'receivings', 4, 'grn/receipt/4'),
(83, 10, 7, 3, 'debit', '3805.000', '2017-05-30 19:57:13', 'BILL 0002', 'bill', 'receivings', 3, 'grn/billreceipt/3'),
(84, 61, 7, 3, 'credit', '3805.000', '2017-05-30 19:57:13', 'BILL 0002', 'bill', 'receivings', 3, 'grn/billreceipt/3'),
(85, 10, 7, 3, 'debit', '195.000', '2017-05-30 19:57:13', 'BILL 0003', 'bill', 'receivings', 4, 'grn/billreceipt/4'),
(86, 61, 7, 3, 'credit', '195.000', '2017-05-30 19:57:13', 'BILL 0003', 'bill', 'receivings', 4, 'grn/billreceipt/4'),
(87, 10, 7, 3, 'debit', '40000.000', '2017-05-30 19:57:51', 'BILL 0002', 'bill', 'receivings', 3, 'grn/billreceipt/3'),
(88, 61, 7, 3, 'credit', '40000.000', '2017-05-30 19:57:51', 'BILL 0002', 'bill', 'receivings', 3, 'grn/billreceipt/3'),
(89, 10, 7, 3, 'debit', '286.000', '2017-05-30 19:58:02', 'BILL 0002', 'bill', 'receivings', 3, 'grn/billreceipt/3'),
(90, 61, 7, 3, 'credit', '286.000', '2017-05-30 19:58:02', 'BILL 0002', 'bill', 'receivings', 3, 'grn/billreceipt/3'),
(91, 9, 7, 3, 'credit', '100.000', '2017-05-30 20:02:00', 'REQ 0001', 'REQ', 'receivings', 6, 'grn/receipt/6'),
(92, 18, 7, 3, 'debit', '100.000', '2017-05-30 20:02:00', 'REQ 0001', 'REQ', 'receivings', 6, 'grn/receipt/6'),
(93, 9, 7, 3, 'credit', '100.000', '2017-05-30 20:02:00', 'REQ 0001', 'REQ', 'receivings', 6, 'grn/receipt/6'),
(94, 18, 7, 3, 'debit', '100.000', '2017-05-30 20:02:00', 'REQ 0001', 'REQ', 'receivings', 6, 'grn/receipt/6'),
(95, 9, 7, 3, 'credit', '100.000', '2017-05-30 20:02:00', 'REQ 0001', 'REQ', 'receivings', 6, 'grn/receipt/6'),
(96, 18, 7, 3, 'debit', '100.000', '2017-05-30 20:02:00', 'REQ 0001', 'REQ', 'receivings', 6, 'grn/receipt/6'),
(97, 18, 10, 8, 'credit', '100.000', '2017-05-30 20:04:13', 'SOC 0001', 'SOC', 'receivings', 7, 'grn/receipt/7'),
(98, 9, 10, 8, 'debit', '100.000', '2017-05-30 20:04:13', 'SOC 0001', 'SOC', 'receivings', 7, 'grn/receipt/7'),
(99, 18, 10, 8, 'credit', '100.000', '2017-05-30 20:04:13', 'SOC 0001', 'SOC', 'receivings', 7, 'grn/receipt/7'),
(100, 9, 10, 8, 'debit', '100.000', '2017-05-30 20:04:13', 'SOC 0001', 'SOC', 'receivings', 7, 'grn/receipt/7'),
(101, 18, 10, 8, 'credit', '100.000', '2017-05-30 20:04:13', 'SOC 0001', 'SOC', 'receivings', 7, 'grn/receipt/7'),
(102, 9, 10, 8, 'debit', '100.000', '2017-05-30 20:04:13', 'SOC 0001', 'SOC', 'receivings', 7, 'grn/receipt/7'),
(103, 9, 7, 3, 'credit', '1000.000', '2017-05-30 20:06:29', 'REQ 0002', 'REQ', 'receivings', 9, 'grn/receipt/9'),
(104, 18, 7, 3, 'debit', '1000.000', '2017-05-30 20:06:29', 'REQ 0002', 'REQ', 'receivings', 9, 'grn/receipt/9'),
(105, 18, 1, 5, 'credit', '1000.000', '2017-05-30 20:06:49', 'SOC 0002', 'SOC', 'receivings', 10, 'grn/receipt/10'),
(106, 9, 1, 5, 'debit', '1000.000', '2017-05-30 20:06:49', 'SOC 0002', 'SOC', 'receivings', 10, 'grn/receipt/10'),
(107, 9, 7, 3, 'debit', '10000.000', '2017-05-30 20:19:29', 'BILL 0004', 'grn', 'receivings', 12, 'grn/receipt/12'),
(108, 10, 7, 3, 'credit', '10000.000', '2017-05-30 20:19:29', 'BILL 0004', 'grn', 'receivings', 12, 'grn/receipt/12'),
(109, 10, 7, 3, 'debit', '10000.000', '2017-05-30 20:19:41', 'BILL 0004', 'bill', 'receivings', 12, 'grn/billreceipt/12'),
(110, 63, 7, 3, 'credit', '10000.000', '2017-05-30 20:19:41', 'BILL 0004', 'bill', 'receivings', 12, 'grn/billreceipt/12'),
(111, 41, 1, 0, 'credit', '43430.000', '2017-06-01 18:55:55', 'Expense Account', 'expenses', 'expenses', 1, NULL),
(112, 54, 1, 0, 'debit', '43430.000', '2017-06-01 18:55:55', 'Expense Account', 'expenses', 'expenses', 1, NULL),
(113, 58, 1, 0, 'credit', '56567.000', '2017-06-01 18:56:31', 'Expense Account', 'expenses', 'expenses', 2, NULL),
(114, 54, 1, 0, 'debit', '56567.000', '2017-06-01 18:56:31', 'Expense Account', 'expenses', 'expenses', 2, NULL),
(115, 55, 1, 0, 'credit', '5675675670.000', '2017-06-01 18:57:21', 'Expense Account', 'expenses', 'expenses', 3, NULL),
(116, 10, 1, 0, 'debit', '5675675670.000', '2017-06-01 18:57:21', 'Expense Account', 'expenses', 'expenses', 3, NULL),
(117, 55, 1, 0, 'credit', '4564560.000', '2017-06-01 18:57:33', 'Expense Account', 'expenses', 'expenses', 4, NULL),
(118, 10, 1, 0, 'debit', '4564560.000', '2017-06-01 18:57:33', 'Expense Account', 'expenses', 'expenses', 4, NULL),
(119, 9, 1, 3, 'debit', '51000.000', '2017-06-01 19:13:59', 'BILL 0005', 'grn', 'receivings', 14, 'grn/receipt/14'),
(120, 10, 1, 3, 'credit', '51000.000', '2017-06-01 19:13:59', 'BILL 0005', 'grn', 'receivings', 14, 'grn/receipt/14'),
(121, 10, 1, 3, 'debit', '51000.000', '2017-06-01 19:21:08', 'BILL 0005', 'bill', 'receivings', 14, 'grn/billreceipt/14'),
(122, 61, 1, 3, 'credit', '51000.000', '2017-06-01 19:21:08', 'BILL 0005', 'bill', 'receivings', 14, 'grn/billreceipt/14'),
(123, 65, 1, 0, 'debit', '1000.000', '2017-06-05 14:07:20', 'testing', 'deposit', NULL, NULL, NULL),
(124, 22, 1, 0, 'credit', '1000.000', '2017-06-05 14:07:20', 'testing', 'deposit', NULL, NULL, NULL),
(125, 65, 1, 0, 'debit', '546.000', '2017-06-05 14:40:12', '456', 'deposit', NULL, NULL, NULL),
(126, 22, 1, 0, 'credit', '546.000', '2017-06-05 14:40:12', '456', 'deposit', NULL, NULL, NULL),
(127, 64, 1, 0, 'debit', '567.000', '2017-06-05 14:47:24', '56', 'deposit', NULL, NULL, NULL),
(128, 22, 1, 0, 'credit', '567.000', '2017-06-05 14:47:24', '56', 'deposit', NULL, NULL, NULL),
(129, 64, 1, 0, 'debit', '234.000', '2017-06-05 17:00:38', '234', 'deposit', NULL, NULL, NULL),
(130, 20, 1, 0, 'credit', '234.000', '2017-06-05 17:00:38', '234', 'deposit', NULL, NULL, NULL),
(131, 9, 1, 3, 'debit', '51000.000', '2017-06-05 17:40:16', 'BILL 0006', 'grn', 'receivings', 16, 'grn/receipt/16'),
(132, 10, 1, 3, 'credit', '51000.000', '2017-06-05 17:40:16', 'BILL 0006', 'grn', 'receivings', 16, 'grn/receipt/16'),
(133, 9, 1, 2, 'debit', '320.000', '2017-06-05 17:40:18', 'BILL 0007', 'grn', 'receivings', 18, 'grn/receipt/18'),
(134, 10, 1, 2, 'credit', '320.000', '2017-06-05 17:40:18', 'BILL 0007', 'grn', 'receivings', 18, 'grn/receipt/18'),
(135, 10, 1, 3, 'debit', '51000.000', '2017-06-05 17:46:13', 'BILL 0006', 'bill', 'receivings', 16, 'grn/billreceipt/16'),
(136, 61, 1, 3, 'credit', '51000.000', '2017-06-05 17:46:13', 'BILL 0006', 'bill', 'receivings', 16, 'grn/billreceipt/16'),
(137, 10, 1, 2, 'debit', '320.000', '2017-06-05 17:46:35', 'BILL 0007', 'bill', 'receivings', 18, 'grn/billreceipt/18'),
(138, 61, 1, 2, 'credit', '320.000', '2017-06-05 17:46:35', 'BILL 0007', 'bill', 'receivings', 18, 'grn/billreceipt/18'),
(139, 60, 1, 0, 'credit', '50.000', '2017-06-05 17:53:47', 'Expense Account', 'expenses', 'expenses', 5, NULL),
(140, 53, 1, 0, 'debit', '50.000', '2017-06-05 17:53:47', 'Expense Account', 'expenses', 'expenses', 5, NULL),
(141, 65, 1, 0, 'debit', '43.000', '2017-06-06 13:30:57', '345', 'deposit', NULL, NULL, NULL),
(142, 20, 1, 0, 'credit', '43.000', '2017-06-06 13:30:57', '345', 'deposit', NULL, NULL, NULL),
(143, 65, 1, 0, 'credit', '23423.000', '2017-06-06 13:37:27', '234234', 'deposit', NULL, NULL, NULL),
(144, 20, 1, 0, 'debit', '23423.000', '2017-06-06 13:37:27', '234234', 'deposit', NULL, NULL, NULL),
(145, 65, 1, 0, 'credit', '234234.000', '2017-06-06 13:37:36', 'rtetrtert', 'deposit', NULL, NULL, NULL),
(146, 20, 1, 0, 'debit', '234234.000', '2017-06-06 13:37:36', 'rtetrtert', 'deposit', NULL, NULL, NULL),
(147, 24, 1, 0, 'credit', '567567.000', '2017-06-06 14:03:48', 'Other Income ', 'income', 'income', 1, NULL),
(148, 54, 1, 0, 'debit', '567567.000', '2017-06-06 14:03:48', 'Other Income ', 'income', 'income', 1, NULL),
(149, 24, 1, 0, 'credit', '567567.000', '2017-06-06 14:04:15', 'Other Income ', 'income', 'income', 2, NULL),
(150, 14, 1, 0, 'debit', '567567.000', '2017-06-06 14:04:15', 'Other Income ', 'income', 'income', 2, NULL),
(151, 9, 1, 2, 'debit', '320.000', '2017-06-06 20:22:12', 'BILL 0008', 'grn', 'receivings', 20, 'grn/receipt/20'),
(152, 10, 1, 2, 'credit', '320.000', '2017-06-06 20:22:13', 'BILL 0008', 'grn', 'receivings', 20, 'grn/receipt/20'),
(153, 10, 1, 2, 'debit', '320.000', '2017-06-06 20:24:04', 'BILL 0008', 'bill', 'receivings', 20, 'grn/billreceipt/20'),
(154, 61, 1, 2, 'credit', '320.000', '2017-06-06 20:24:04', 'BILL 0008', 'bill', 'receivings', 20, 'grn/billreceipt/20'),
(155, 64, 1, 0, 'debit', '100.000', '2017-06-12 17:29:11', '125', 'deposit', NULL, NULL, NULL),
(156, 20, 1, 0, 'credit', '100.000', '2017-06-12 17:29:11', '125', 'deposit', NULL, NULL, NULL),
(157, 64, 1, 0, 'credit', '100.000', '2017-06-12 17:29:25', '414', 'deposit', NULL, NULL, NULL),
(158, 20, 1, 0, 'debit', '100.000', '2017-06-12 17:29:25', '414', 'deposit', NULL, NULL, NULL),
(159, 9, 1, 2, 'credit', '430.000', '2017-06-12 20:27:36', '', 'InventoryAdjustments', 'inventory', 1, 'inventories/details/1/2'),
(160, 30, 1, 2, 'debit', '430.000', '2017-06-12 20:27:36', '', 'InventoryAdjustments', 'inventory', 1, 'inventories/details/1/2'),
(161, 9, 1, 2, 'credit', '250.000', '2017-06-12 20:28:13', 'REQ 0003', 'REQ', 'receivings', 45, 'grn/receipt/45'),
(162, 18, 1, 2, 'debit', '250.000', '2017-06-12 20:28:13', 'REQ 0003', 'REQ', 'receivings', 45, 'grn/receipt/45'),
(163, 9, 1, 2, 'credit', '20.000', '2017-06-12 20:28:13', 'REQ 0003', 'REQ', 'receivings', 45, 'grn/receipt/45'),
(164, 18, 1, 2, 'debit', '20.000', '2017-06-12 20:28:13', 'REQ 0003', 'REQ', 'receivings', 45, 'grn/receipt/45'),
(165, 9, 1, 3, 'credit', '150.000', '2017-06-12 21:06:42', 'REQ 0004', 'REQ', 'receivings', 51, 'grn/receipt/51'),
(166, 18, 1, 3, 'debit', '150.000', '2017-06-12 21:06:42', 'REQ 0004', 'REQ', 'receivings', 51, 'grn/receipt/51'),
(167, 9, 1, 3, 'credit', '200.000', '2017-06-12 21:08:35', 'REQ 0005', 'REQ', 'receivings', 52, 'grn/receipt/52'),
(168, 18, 1, 3, 'debit', '200.000', '2017-06-12 21:08:35', 'REQ 0005', 'REQ', 'receivings', 52, 'grn/receipt/52'),
(169, 9, 1, 6, 'debit', '0.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/6'),
(170, 22, 1, 6, 'credit', '0.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/6'),
(171, 9, 1, 8, 'debit', '100.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/8'),
(172, 22, 1, 8, 'credit', '100.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/8'),
(173, 9, 1, 5, 'debit', '0.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/5'),
(174, 22, 1, 5, 'credit', '0.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/5'),
(175, 9, 1, 4, 'debit', '0.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/4'),
(176, 22, 1, 4, 'credit', '0.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/4'),
(177, 9, 1, 2, 'debit', '5680430.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/2'),
(178, 22, 1, 2, 'credit', '5680430.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/2'),
(179, 9, 1, 3, 'debit', '29710.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/3'),
(180, 22, 1, 3, 'credit', '29710.000', '2017-06-13 12:02:35', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/3'),
(181, 9, 1, 3, 'debit', '30.000', '2017-06-14 11:48:21', 'BILL 0009', 'grn', 'receivings', 49, 'grn/receipt/49'),
(182, 10, 1, 3, 'credit', '30.000', '2017-06-14 11:48:22', 'BILL 0009', 'grn', 'receivings', 49, 'grn/receipt/49'),
(183, 9, 1, 2, 'debit', '550.000', '2017-06-14 11:48:52', 'BILL 0010', 'grn', 'receivings', 54, 'grn/receipt/54'),
(184, 10, 1, 2, 'credit', '550.000', '2017-06-14 11:48:52', 'BILL 0010', 'grn', 'receivings', 54, 'grn/receipt/54'),
(185, 10, 1, 2, 'debit', '550.000', '2017-06-14 11:54:56', 'BILL 0010', 'bill', 'receivings', 54, 'grn/billreceipt/54'),
(186, 62, 1, 2, 'credit', '550.000', '2017-06-14 11:54:56', 'BILL 0010', 'bill', 'receivings', 54, 'grn/billreceipt/54'),
(187, 9, 1, 2, 'debit', '550.000', '2017-06-14 12:04:09', 'BILL 0011', 'grn', 'receivings', 55, 'grn/receipt/55'),
(188, 10, 1, 2, 'credit', '550.000', '2017-06-14 12:04:09', 'BILL 0011', 'grn', 'receivings', 55, 'grn/receipt/55'),
(189, 10, 1, 2, 'debit', '550.000', '2017-06-14 12:05:33', 'BILL 0011', 'bill', 'receivings', 55, 'grn/billreceipt/55'),
(190, 62, 1, 2, 'credit', '550.000', '2017-06-14 12:05:33', 'BILL 0011', 'bill', 'receivings', 55, 'grn/billreceipt/55'),
(191, 86, 1, 0, 'debit', '1000.000', '2017-06-14 18:20:54', 'ref', 'deposit', NULL, NULL, NULL),
(192, 20, 1, 0, 'credit', '1000.000', '2017-06-14 18:20:55', 'ref', 'deposit', NULL, NULL, NULL),
(193, 86, 1, 0, 'debit', '2000.000', '2017-06-14 18:21:37', 'ref2', 'deposit', NULL, NULL, NULL),
(194, 65, 1, 0, 'credit', '2000.000', '2017-06-14 18:21:37', 'ref2', 'deposit', NULL, NULL, NULL),
(195, 86, 1, 0, 'credit', '1500.000', '2017-06-14 18:21:55', 'ref3', 'deposit', NULL, NULL, NULL),
(196, 20, 1, 0, 'debit', '1500.000', '2017-06-14 18:21:55', 'ref3', 'deposit', NULL, NULL, NULL),
(197, 9, 1, 2, 'debit', '100.000', '2017-06-15 13:55:34', 'BILL 0012', 'grn', 'receivings', 58, 'grn/receipt/58'),
(198, 10, 1, 2, 'credit', '100.000', '2017-06-15 13:55:34', 'BILL 0012', 'grn', 'receivings', 58, 'grn/receipt/58'),
(199, 9, 1, 2, 'debit', '430.000', '2017-06-15 13:55:50', 'BILL 0013', 'grn', 'receivings', 57, 'grn/receipt/57'),
(200, 10, 1, 2, 'credit', '430.000', '2017-06-15 13:55:50', 'BILL 0013', 'grn', 'receivings', 57, 'grn/receipt/57'),
(201, 9, 1, 6, 'debit', '0.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/6'),
(202, 22, 1, 6, 'credit', '0.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/6'),
(203, 9, 1, 8, 'debit', '100.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/8'),
(204, 22, 1, 8, 'credit', '100.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/8'),
(205, 9, 1, 5, 'debit', '0.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/5'),
(206, 22, 1, 5, 'credit', '0.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/5'),
(207, 9, 1, 4, 'debit', '0.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/4'),
(208, 22, 1, 4, 'credit', '0.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/4'),
(209, 9, 1, 2, 'debit', '1380.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/2'),
(210, 22, 1, 2, 'credit', '1380.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/2'),
(211, 9, 1, 3, 'debit', '29900.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/3'),
(212, 22, 1, 3, 'credit', '29900.000', '2017-06-15 14:42:43', 'Manual Edit of Quantity', 'items_manually', 'items', 2, 'inventories/details2/3'),
(213, 9, 1, 6, 'debit', '0.000', '2017-06-15 14:45:37', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(214, 22, 1, 6, 'credit', '0.000', '2017-06-15 14:45:37', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(215, 9, 1, 8, 'debit', '0.000', '2017-06-15 14:45:38', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(216, 22, 1, 8, 'credit', '0.000', '2017-06-15 14:45:38', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(217, 9, 1, 5, 'debit', '0.000', '2017-06-15 14:45:38', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(218, 22, 1, 5, 'credit', '0.000', '2017-06-15 14:45:38', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(219, 9, 1, 4, 'debit', '0.000', '2017-06-15 14:45:38', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(220, 22, 1, 4, 'credit', '0.000', '2017-06-15 14:45:38', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(221, 9, 1, 2, 'debit', '0.000', '2017-06-15 14:45:39', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(222, 22, 1, 2, 'credit', '0.000', '2017-06-15 14:45:39', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(223, 9, 1, 3, 'debit', '0.000', '2017-06-15 14:45:39', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(224, 22, 1, 3, 'credit', '0.000', '2017-06-15 14:45:39', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(225, 9, 1, 6, 'debit', '0.000', '2017-06-15 14:45:40', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/6'),
(226, 22, 1, 6, 'credit', '0.000', '2017-06-15 14:45:40', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/6'),
(227, 9, 1, 8, 'debit', '0.000', '2017-06-15 14:45:40', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/8'),
(228, 22, 1, 8, 'credit', '0.000', '2017-06-15 14:45:40', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/8'),
(229, 9, 1, 5, 'debit', '0.000', '2017-06-15 14:45:41', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/5'),
(230, 22, 1, 5, 'credit', '0.000', '2017-06-15 14:45:41', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/5'),
(231, 9, 1, 4, 'debit', '0.000', '2017-06-15 14:45:41', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/4'),
(232, 22, 1, 4, 'credit', '0.000', '2017-06-15 14:45:41', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/4'),
(233, 9, 1, 2, 'debit', '0.000', '2017-06-15 14:45:41', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/2'),
(234, 22, 1, 2, 'credit', '0.000', '2017-06-15 14:45:41', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/2'),
(235, 9, 1, 3, 'debit', '0.000', '2017-06-15 14:45:41', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/3'),
(236, 22, 1, 3, 'credit', '0.000', '2017-06-15 14:45:41', 'Manual Edit of Quantity', 'items_manually', 'items', 11, 'inventories/details11/3'),
(237, 9, 1, 6, 'debit', '50.000', '2017-06-15 14:48:05', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(238, 22, 1, 6, 'credit', '50.000', '2017-06-15 14:48:05', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(239, 9, 1, 8, 'debit', '66.000', '2017-06-15 14:48:05', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(240, 22, 1, 8, 'credit', '66.000', '2017-06-15 14:48:05', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(241, 9, 1, 5, 'debit', '0.000', '2017-06-15 14:48:05', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(242, 22, 1, 5, 'credit', '0.000', '2017-06-15 14:48:06', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(243, 9, 1, 4, 'debit', '0.000', '2017-06-15 14:48:06', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(244, 22, 1, 4, 'credit', '0.000', '2017-06-15 14:48:06', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(245, 9, 1, 2, 'debit', '220.000', '2017-06-15 14:48:06', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(246, 22, 1, 2, 'credit', '220.000', '2017-06-15 14:48:06', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(247, 9, 1, 3, 'debit', '252.000', '2017-06-15 14:48:06', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(248, 22, 1, 3, 'credit', '252.000', '2017-06-15 14:48:06', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(249, 9, 1, 6, 'debit', '50.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(250, 22, 1, 6, 'credit', '50.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(251, 9, 1, 8, 'debit', '66.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(252, 22, 1, 8, 'credit', '66.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(253, 9, 1, 5, 'debit', '0.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(254, 22, 1, 5, 'credit', '0.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(255, 9, 1, 4, 'debit', '0.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(256, 22, 1, 4, 'credit', '0.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(257, 9, 1, 2, 'debit', '220.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(258, 22, 1, 2, 'credit', '220.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(259, 9, 1, 3, 'debit', '252.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(260, 22, 1, 3, 'credit', '252.000', '2017-06-15 14:48:07', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(261, 9, 1, 6, 'debit', '50.000', '2017-06-15 14:48:43', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(262, 22, 1, 6, 'credit', '50.000', '2017-06-15 14:48:43', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(263, 9, 1, 8, 'debit', '66.000', '2017-06-15 14:48:43', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(264, 22, 1, 8, 'credit', '66.000', '2017-06-15 14:48:43', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(265, 9, 1, 5, 'debit', '0.000', '2017-06-15 14:48:43', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(266, 22, 1, 5, 'credit', '0.000', '2017-06-15 14:48:43', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(267, 9, 1, 4, 'debit', '0.000', '2017-06-15 14:48:43', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(268, 22, 1, 4, 'credit', '0.000', '2017-06-15 14:48:44', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(269, 9, 1, 2, 'debit', '220.000', '2017-06-15 14:48:44', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(270, 22, 1, 2, 'credit', '220.000', '2017-06-15 14:48:44', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(271, 9, 1, 3, 'debit', '252.000', '2017-06-15 14:48:44', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(272, 22, 1, 3, 'credit', '252.000', '2017-06-15 14:48:44', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(273, 9, 1, 6, 'debit', '50.000', '2017-06-15 14:49:13', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(274, 22, 1, 6, 'credit', '50.000', '2017-06-15 14:49:13', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(275, 9, 1, 8, 'debit', '66.000', '2017-06-15 14:49:13', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(276, 22, 1, 8, 'credit', '66.000', '2017-06-15 14:49:14', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(277, 9, 1, 5, 'debit', '0.000', '2017-06-15 14:49:14', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(278, 22, 1, 5, 'credit', '0.000', '2017-06-15 14:49:14', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(279, 9, 1, 4, 'debit', '0.000', '2017-06-15 14:49:14', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(280, 22, 1, 4, 'credit', '0.000', '2017-06-15 14:49:14', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(281, 9, 1, 2, 'debit', '220.000', '2017-06-15 14:49:14', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(282, 22, 1, 2, 'credit', '220.000', '2017-06-15 14:49:14', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(283, 9, 1, 3, 'debit', '252.000', '2017-06-15 14:49:14', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(284, 22, 1, 3, 'credit', '252.000', '2017-06-15 14:49:14', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(285, 9, 1, 6, 'debit', '50.000', '2017-06-15 14:49:48', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(286, 22, 1, 6, 'credit', '50.000', '2017-06-15 14:49:48', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(287, 9, 1, 8, 'debit', '66.000', '2017-06-15 14:49:48', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(288, 22, 1, 8, 'credit', '66.000', '2017-06-15 14:49:48', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(289, 9, 1, 5, 'debit', '0.000', '2017-06-15 14:49:48', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(290, 22, 1, 5, 'credit', '0.000', '2017-06-15 14:49:48', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(291, 9, 1, 4, 'debit', '0.000', '2017-06-15 14:49:48', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(292, 22, 1, 4, 'credit', '0.000', '2017-06-15 14:49:48', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(293, 9, 1, 2, 'debit', '220.000', '2017-06-15 14:49:49', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(294, 22, 1, 2, 'credit', '220.000', '2017-06-15 14:49:49', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(295, 9, 1, 3, 'debit', '252.000', '2017-06-15 14:49:49', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(296, 22, 1, 3, 'credit', '252.000', '2017-06-15 14:49:49', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(297, 9, 1, 2, 'debit', '240.000', '2017-06-15 17:01:19', 'BILL 0014', 'grn', 'receivings', 60, 'grn/receipt/60'),
(298, 10, 1, 2, 'credit', '240.000', '2017-06-15 17:01:19', 'BILL 0014', 'grn', 'receivings', 60, 'grn/receipt/60'),
(299, 9, 1, 2, 'debit', '60.000', '2017-06-15 17:36:21', 'BILL 0015', 'grn', 'receivings', 62, 'grn/receipt/62'),
(300, 10, 1, 2, 'credit', '60.000', '2017-06-15 17:36:21', 'BILL 0015', 'grn', 'receivings', 62, 'grn/receipt/62'),
(301, 9, 1, 6, 'debit', '20.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(302, 22, 1, 6, 'credit', '20.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/6'),
(303, 9, 1, 8, 'debit', '66.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(304, 22, 1, 8, 'credit', '66.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/8'),
(305, 9, 1, 5, 'debit', '0.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(306, 22, 1, 5, 'credit', '0.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/5'),
(307, 9, 1, 4, 'debit', '0.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(308, 22, 1, 4, 'credit', '0.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/4'),
(309, 9, 1, 2, 'debit', '605.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(310, 22, 1, 2, 'credit', '605.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/2'),
(311, 9, 1, 3, 'debit', '252.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(312, 22, 1, 3, 'credit', '252.000', '2017-06-15 18:12:26', 'Manual Edit of Quantity', 'items_manually', 'items', 10, 'inventories/details10/3'),
(313, 9, 1, 6, 'debit', '0.000', '2017-06-15 18:14:26', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/6'),
(314, 22, 1, 6, 'credit', '0.000', '2017-06-15 18:14:27', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/6'),
(315, 9, 1, 8, 'debit', '0.000', '2017-06-15 18:14:27', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/8'),
(316, 22, 1, 8, 'credit', '0.000', '2017-06-15 18:14:27', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/8'),
(317, 9, 1, 5, 'debit', '0.000', '2017-06-15 18:14:28', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/5'),
(318, 22, 1, 5, 'credit', '0.000', '2017-06-15 18:14:28', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/5'),
(319, 9, 1, 4, 'debit', '0.000', '2017-06-15 18:14:28', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/4'),
(320, 22, 1, 4, 'credit', '0.000', '2017-06-15 18:14:28', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/4'),
(321, 9, 1, 2, 'debit', '0.000', '2017-06-15 18:14:28', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/2'),
(322, 22, 1, 2, 'credit', '0.000', '2017-06-15 18:14:28', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/2'),
(323, 9, 1, 3, 'debit', '0.000', '2017-06-15 18:14:28', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/3'),
(324, 22, 1, 3, 'credit', '0.000', '2017-06-15 18:14:28', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/3'),
(325, 9, 1, 6, 'debit', '0.000', '2017-06-15 18:16:30', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/6'),
(326, 22, 1, 6, 'credit', '0.000', '2017-06-15 18:16:30', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/6'),
(327, 9, 1, 8, 'debit', '0.000', '2017-06-15 18:16:30', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/8'),
(328, 22, 1, 8, 'credit', '0.000', '2017-06-15 18:16:30', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/8'),
(329, 9, 1, 5, 'debit', '0.000', '2017-06-15 18:16:30', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/5'),
(330, 22, 1, 5, 'credit', '0.000', '2017-06-15 18:16:30', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/5'),
(331, 9, 1, 4, 'debit', '0.000', '2017-06-15 18:16:30', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/4'),
(332, 22, 1, 4, 'credit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/4'),
(333, 9, 1, 2, 'debit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/2'),
(334, 22, 1, 2, 'credit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/2'),
(335, 9, 1, 3, 'debit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/3'),
(336, 22, 1, 3, 'credit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/3'),
(337, 9, 1, 6, 'debit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/6'),
(338, 22, 1, 6, 'credit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/6'),
(339, 9, 1, 8, 'debit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/8'),
(340, 22, 1, 8, 'credit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/8'),
(341, 9, 1, 5, 'debit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/5'),
(342, 22, 1, 5, 'credit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/5'),
(343, 9, 1, 4, 'debit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/4'),
(344, 22, 1, 4, 'credit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/4'),
(345, 9, 1, 2, 'debit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/2'),
(346, 22, 1, 2, 'credit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/2'),
(347, 9, 1, 3, 'debit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/3'),
(348, 22, 1, 3, 'credit', '0.000', '2017-06-15 18:16:31', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/3'),
(349, 9, 1, 6, 'debit', '1100.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/6'),
(350, 22, 1, 6, 'credit', '1100.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/6'),
(351, 9, 1, 8, 'debit', '0.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/8'),
(352, 22, 1, 8, 'credit', '0.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/8'),
(353, 9, 1, 5, 'debit', '0.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/5'),
(354, 22, 1, 5, 'credit', '0.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/5'),
(355, 9, 1, 4, 'debit', '0.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/4'),
(356, 22, 1, 4, 'credit', '0.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/4'),
(357, 9, 1, 2, 'debit', '525.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/2'),
(358, 22, 1, 2, 'credit', '525.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/2'),
(359, 9, 1, 3, 'debit', '0.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/3'),
(360, 22, 1, 3, 'credit', '0.000', '2017-06-15 18:18:34', 'Manual Edit of Quantity', 'items_manually', 'items', 12, 'inventories/details12/3'),
(361, 9, 1, 6, 'debit', '115000.000', '2017-06-15 20:04:36', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/6'),
(362, 22, 1, 6, 'credit', '115000.000', '2017-06-15 20:04:37', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/6'),
(363, 9, 1, 8, 'debit', '0.000', '2017-06-15 20:04:37', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/8'),
(364, 22, 1, 8, 'credit', '0.000', '2017-06-15 20:04:37', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/8'),
(365, 9, 1, 5, 'debit', '0.000', '2017-06-15 20:04:37', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/5'),
(366, 22, 1, 5, 'credit', '0.000', '2017-06-15 20:04:37', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/5'),
(367, 9, 1, 4, 'debit', '0.000', '2017-06-15 20:04:37', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/4'),
(368, 22, 1, 4, 'credit', '0.000', '2017-06-15 20:04:37', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/4'),
(369, 9, 1, 2, 'debit', '0.000', '2017-06-15 20:04:37', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/2'),
(370, 22, 1, 2, 'credit', '0.000', '2017-06-15 20:04:37', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/2'),
(371, 9, 1, 3, 'debit', '0.000', '2017-06-15 20:04:38', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/3'),
(372, 22, 1, 3, 'credit', '0.000', '2017-06-15 20:04:38', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/3'),
(373, 9, 1, 6, 'debit', '15000.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/6'),
(374, 22, 1, 6, 'credit', '15000.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/6'),
(375, 9, 1, 8, 'debit', '0.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/8'),
(376, 22, 1, 8, 'credit', '0.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/8'),
(377, 9, 1, 5, 'debit', '0.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/5'),
(378, 22, 1, 5, 'credit', '0.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/5'),
(379, 9, 1, 4, 'debit', '0.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/4');
INSERT INTO `ospos_account_trans` (`id`, `account_id`, `employee_id`, `location_id`, `trans_type`, `amount`, `trans_date`, `reference`, `reference_type`, `reference_table`, `reference_id`, `url`) VALUES
(380, 22, 1, 4, 'credit', '0.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/4'),
(381, 9, 1, 2, 'debit', '11400.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/2'),
(382, 22, 1, 2, 'credit', '11400.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/2'),
(383, 9, 1, 3, 'debit', '0.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/3'),
(384, 22, 1, 3, 'credit', '0.000', '2017-06-15 20:06:21', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/3'),
(385, 9, 1, 2, 'debit', '166.000', '2017-06-15 20:17:13', 'BILL 0016', 'grn', 'receivings', 63, 'grn/receipt/63'),
(386, 10, 1, 2, 'credit', '166.000', '2017-06-15 20:17:13', 'BILL 0016', 'grn', 'receivings', 63, 'grn/receipt/63'),
(387, 9, 1, 3, 'debit', '20.000', '2017-06-16 11:27:41', 'BILL 0017', 'grn', 'receivings', 48, 'grn/receipt/48'),
(388, 10, 1, 3, 'credit', '20.000', '2017-06-16 11:27:41', 'BILL 0017', 'grn', 'receivings', 48, 'grn/receipt/48'),
(389, 10, 1, 2, 'debit', '166.000', '2017-06-16 13:49:03', 'BILL 0016', 'bill', 'receivings', 63, 'grn/billreceipt/63'),
(390, 59, 1, 2, 'credit', '166.000', '2017-06-16 13:49:03', 'BILL 0016', 'bill', 'receivings', 63, 'grn/billreceipt/63'),
(391, 10, 1, 2, 'debit', '100.000', '2017-06-16 13:49:23', 'BILL 0012', 'bill', 'receivings', 58, 'grn/billreceipt/58'),
(392, 59, 1, 2, 'credit', '100.000', '2017-06-16 13:49:23', 'BILL 0012', 'bill', 'receivings', 58, 'grn/billreceipt/58'),
(393, 9, 1, 6, 'debit', '0.000', '2017-06-19 12:55:22', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/6'),
(394, 22, 1, 6, 'credit', '0.000', '2017-06-19 12:55:22', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/6'),
(395, 9, 1, 8, 'debit', '100.000', '2017-06-19 12:55:22', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/8'),
(396, 22, 1, 8, 'credit', '100.000', '2017-06-19 12:55:22', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/8'),
(397, 9, 1, 5, 'debit', '0.000', '2017-06-19 12:55:22', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/5'),
(398, 22, 1, 5, 'credit', '0.000', '2017-06-19 12:55:22', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/5'),
(399, 9, 1, 4, 'debit', '0.000', '2017-06-19 12:55:22', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/4'),
(400, 22, 1, 4, 'credit', '0.000', '2017-06-19 12:55:22', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/4'),
(401, 9, 1, 2, 'debit', '5680550.000', '2017-06-19 12:55:23', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/2'),
(402, 22, 1, 2, 'credit', '5680550.000', '2017-06-19 12:55:23', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/2'),
(403, 9, 1, 3, 'debit', '29710.000', '2017-06-19 12:55:23', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/3'),
(404, 22, 1, 3, 'credit', '29710.000', '2017-06-19 12:55:23', 'Manual Edit of Quantity', 'items_manually', 'items', 1, 'inventories/details1/3'),
(405, 9, 1, 6, 'debit', '550.000', '2017-06-19 13:02:19', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/6'),
(406, 22, 1, 6, 'credit', '550.000', '2017-06-19 13:02:19', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/6'),
(407, 9, 1, 8, 'debit', '660.000', '2017-06-19 13:02:19', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/8'),
(408, 22, 1, 8, 'credit', '660.000', '2017-06-19 13:02:19', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/8'),
(409, 9, 1, 5, 'debit', '0.000', '2017-06-19 13:02:19', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/5'),
(410, 22, 1, 5, 'credit', '0.000', '2017-06-19 13:02:20', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/5'),
(411, 9, 1, 4, 'debit', '0.000', '2017-06-19 13:02:20', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/4'),
(412, 22, 1, 4, 'credit', '0.000', '2017-06-19 13:02:20', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/4'),
(413, 9, 1, 2, 'debit', '650.000', '2017-06-19 13:02:20', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/2'),
(414, 22, 1, 2, 'credit', '650.000', '2017-06-19 13:02:20', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/2'),
(415, 9, 1, 3, 'debit', '0.000', '2017-06-19 13:02:20', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/3'),
(416, 22, 1, 3, 'credit', '0.000', '2017-06-19 13:02:20', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/3'),
(417, 9, 1, 6, 'debit', '550.000', '2017-06-19 13:02:39', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/6'),
(418, 22, 1, 6, 'credit', '550.000', '2017-06-19 13:02:39', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/6'),
(419, 9, 1, 8, 'debit', '660.000', '2017-06-19 13:02:39', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/8'),
(420, 22, 1, 8, 'credit', '660.000', '2017-06-19 13:02:39', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/8'),
(421, 9, 1, 5, 'debit', '0.000', '2017-06-19 13:02:39', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/5'),
(422, 22, 1, 5, 'credit', '0.000', '2017-06-19 13:02:39', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/5'),
(423, 9, 1, 4, 'debit', '0.000', '2017-06-19 13:02:39', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/4'),
(424, 22, 1, 4, 'credit', '0.000', '2017-06-19 13:02:40', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/4'),
(425, 9, 1, 2, 'debit', '650.000', '2017-06-19 13:02:40', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/2'),
(426, 22, 1, 2, 'credit', '650.000', '2017-06-19 13:02:40', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/2'),
(427, 9, 1, 3, 'debit', '0.000', '2017-06-19 13:02:40', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/3'),
(428, 22, 1, 3, 'credit', '0.000', '2017-06-19 13:02:40', 'Manual Edit of Quantity', 'items_manually', 'items', 14, 'inventories/details14/3'),
(429, 9, 1, 2, 'debit', '100.000', '2017-06-19 13:30:26', 'BILL 0018', 'grn', 'receivings', 66, 'grn/receipt/66'),
(430, 10, 1, 2, 'credit', '100.000', '2017-06-19 13:30:26', 'BILL 0018', 'grn', 'receivings', 66, 'grn/receipt/66'),
(431, 9, 1, 6, 'debit', '138.000', '2017-06-19 13:51:35', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/6'),
(432, 22, 1, 6, 'credit', '138.000', '2017-06-19 13:51:35', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/6'),
(433, 9, 1, 8, 'debit', '0.000', '2017-06-19 13:51:35', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/8'),
(434, 22, 1, 8, 'credit', '0.000', '2017-06-19 13:51:35', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/8'),
(435, 9, 1, 5, 'debit', '0.000', '2017-06-19 13:51:36', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/5'),
(436, 22, 1, 5, 'credit', '0.000', '2017-06-19 13:51:36', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/5'),
(437, 9, 1, 4, 'debit', '0.000', '2017-06-19 13:51:36', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/4'),
(438, 22, 1, 4, 'credit', '0.000', '2017-06-19 13:51:36', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/4'),
(439, 9, 1, 2, 'debit', '198.000', '2017-06-19 13:51:36', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/2'),
(440, 22, 1, 2, 'credit', '198.000', '2017-06-19 13:51:36', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/2'),
(441, 9, 1, 3, 'debit', '0.000', '2017-06-19 13:51:36', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/3'),
(442, 22, 1, 3, 'credit', '0.000', '2017-06-19 13:51:36', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/3'),
(443, 9, 1, 6, 'debit', '138.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/6'),
(444, 22, 1, 6, 'credit', '138.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/6'),
(445, 9, 1, 8, 'debit', '0.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/8'),
(446, 22, 1, 8, 'credit', '0.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/8'),
(447, 9, 1, 5, 'debit', '0.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/5'),
(448, 22, 1, 5, 'credit', '0.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/5'),
(449, 9, 1, 4, 'debit', '0.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/4'),
(450, 22, 1, 4, 'credit', '0.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/4'),
(451, 9, 1, 2, 'debit', '198.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/2'),
(452, 22, 1, 2, 'credit', '198.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/2'),
(453, 9, 1, 3, 'debit', '0.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/3'),
(454, 22, 1, 3, 'credit', '0.000', '2017-06-19 13:53:18', 'Manual Edit of Quantity', 'items_manually', 'items', 15, 'inventories/details15/3'),
(455, 9, 1, 2, 'debit', '100.000', '2017-06-19 14:31:21', 'BILL 0019', 'grn', 'receivings', 77, 'grn/receipt/77'),
(456, 10, 1, 2, 'credit', '100.000', '2017-06-19 14:31:21', 'BILL 0019', 'grn', 'receivings', 77, 'grn/receipt/77'),
(457, 9, 1, 2, 'credit', '670.000', '2017-06-19 17:24:27', 'Comments', 'InventoryAdjustments', 'inventory', 1, 'inventories/details/1/2'),
(458, 30, 1, 2, 'debit', '670.000', '2017-06-19 17:24:27', 'Comments', 'InventoryAdjustments', 'inventory', 1, 'inventories/details/1/2'),
(459, 9, 1, 6, 'debit', '0.000', '2017-06-19 19:48:38', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/6'),
(460, 22, 1, 6, 'credit', '0.000', '2017-06-19 19:48:38', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/6'),
(461, 9, 1, 8, 'debit', '0.000', '2017-06-19 19:48:38', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/8'),
(462, 22, 1, 8, 'credit', '0.000', '2017-06-19 19:48:38', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/8'),
(463, 9, 1, 5, 'debit', '0.000', '2017-06-19 19:48:38', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/5'),
(464, 22, 1, 5, 'credit', '0.000', '2017-06-19 19:48:38', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/5'),
(465, 9, 1, 4, 'debit', '0.000', '2017-06-19 19:48:39', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/4'),
(466, 22, 1, 4, 'credit', '0.000', '2017-06-19 19:48:39', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/4'),
(467, 9, 1, 2, 'debit', '0.000', '2017-06-19 19:48:39', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/2'),
(468, 22, 1, 2, 'credit', '0.000', '2017-06-19 19:48:39', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/2'),
(469, 9, 1, 3, 'debit', '0.000', '2017-06-19 19:48:39', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/3'),
(470, 22, 1, 3, 'credit', '0.000', '2017-06-19 19:48:39', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/3'),
(471, 9, 1, 6, 'debit', '2100.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/6'),
(472, 22, 1, 6, 'credit', '2100.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/6'),
(473, 9, 1, 8, 'debit', '0.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/8'),
(474, 22, 1, 8, 'credit', '0.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/8'),
(475, 9, 1, 5, 'debit', '0.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/5'),
(476, 22, 1, 5, 'credit', '0.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/5'),
(477, 9, 1, 4, 'debit', '0.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/4'),
(478, 22, 1, 4, 'credit', '0.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/4'),
(479, 9, 1, 2, 'debit', '2240.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/2'),
(480, 22, 1, 2, 'credit', '2240.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/2'),
(481, 9, 1, 3, 'debit', '0.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/3'),
(482, 22, 1, 3, 'credit', '0.000', '2017-06-19 19:49:45', 'Manual Edit of Quantity', 'items_manually', 'items', 16, 'inventories/details16/3'),
(483, 9, 1, 2, 'debit', '1350.000', '2017-06-19 20:04:23', 'BILL 0020', 'grn', 'receivings', 83, 'grn/receipt/83'),
(484, 10, 1, 2, 'credit', '1350.000', '2017-06-19 20:04:23', 'BILL 0020', 'grn', 'receivings', 83, 'grn/receipt/83'),
(485, 9, 1, 2, 'debit', '450.000', '2017-06-19 20:04:27', 'BILL 0021', 'grn', 'receivings', 84, 'grn/receipt/84'),
(486, 10, 1, 2, 'credit', '450.000', '2017-06-19 20:04:27', 'BILL 0021', 'grn', 'receivings', 84, 'grn/receipt/84'),
(487, 10, 1, 2, 'debit', '450.000', '2017-06-19 20:12:04', 'BILL 0021', 'bill', 'receivings', 84, 'grn/billreceipt/84'),
(488, 61, 1, 2, 'credit', '450.000', '2017-06-19 20:12:04', 'BILL 0021', 'bill', 'receivings', 84, 'grn/billreceipt/84'),
(489, 10, 1, 2, 'debit', '1350.000', '2017-06-19 20:13:56', 'BILL 0020', 'bill', 'receivings', 83, 'grn/billreceipt/83'),
(490, 61, 1, 2, 'credit', '1350.000', '2017-06-19 20:13:57', 'BILL 0020', 'bill', 'receivings', 83, 'grn/billreceipt/83'),
(491, 9, 1, 2, 'debit', '300.000', '2017-06-20 17:40:47', 'BILL 0022', 'grn', 'receivings', 86, 'grn/receipt/86'),
(492, 10, 1, 2, 'credit', '300.000', '2017-06-20 17:40:47', 'BILL 0022', 'grn', 'receivings', 86, 'grn/receipt/86'),
(493, 9, 1, 2, 'debit', '50.000', '2017-06-20 17:41:00', 'BILL 0023', 'grn', 'receivings', 81, 'grn/receipt/81'),
(494, 10, 1, 2, 'credit', '50.000', '2017-06-20 17:41:00', 'BILL 0023', 'grn', 'receivings', 81, 'grn/receipt/81'),
(495, 9, 1, 2, 'debit', '25.000', '2017-06-20 17:42:36', 'BILL 0024', 'grn', 'receivings', 79, 'grn/receipt/79'),
(496, 10, 1, 2, 'credit', '25.000', '2017-06-20 17:42:36', 'BILL 0024', 'grn', 'receivings', 79, 'grn/receipt/79'),
(497, 9, 1, 2, 'debit', '1800.000', '2017-06-20 17:45:36', 'BILL 0025', 'grn', 'receivings', 88, 'grn/receipt/88'),
(498, 10, 1, 2, 'credit', '1800.000', '2017-06-20 17:45:36', 'BILL 0025', 'grn', 'receivings', 88, 'grn/receipt/88'),
(499, 10, 1, 2, 'debit', '1800.000', '2017-06-20 17:53:48', 'BILL 0025', 'bill', 'receivings', 88, 'grn/billreceipt/88'),
(500, 59, 1, 2, 'credit', '1800.000', '2017-06-20 17:53:48', 'BILL 0025', 'bill', 'receivings', 88, 'grn/billreceipt/88'),
(501, 9, 1, 2, 'debit', '50.000', '2017-06-20 18:03:07', 'BILL 0026', 'grn', 'receivings', 78, 'grn/receipt/78'),
(502, 10, 1, 2, 'credit', '50.000', '2017-06-20 18:03:07', 'BILL 0026', 'grn', 'receivings', 78, 'grn/receipt/78'),
(503, 10, 1, 3, 'debit', '10.000', '2017-06-20 19:10:04', 'BILL 0017', 'bill', 'receivings', 48, 'grn/billreceipt/48'),
(504, 63, 1, 3, 'credit', '10.000', '2017-06-20 19:10:04', 'BILL 0017', 'bill', 'receivings', 48, 'grn/billreceipt/48'),
(505, 10, 1, 3, 'debit', '10.000', '2017-06-20 19:10:04', 'BILL 0009', 'bill', 'receivings', 49, 'grn/billreceipt/49'),
(506, 63, 1, 3, 'credit', '10.000', '2017-06-20 19:10:04', 'BILL 0009', 'bill', 'receivings', 49, 'grn/billreceipt/49'),
(507, 9, 1, 2, 'debit', '10.000', '2017-06-20 20:19:09', 'BILL 0027', 'grn', 'receivings', 38, 'grn/receipt/38'),
(508, 10, 1, 2, 'credit', '10.000', '2017-06-20 20:19:09', 'BILL 0027', 'grn', 'receivings', 38, 'grn/receipt/38'),
(509, 10, 1, 2, 'debit', '240.000', '2017-06-20 20:35:59', 'BILL 0014', 'bill', 'receivings', 60, 'grn/billreceipt/60'),
(510, 60, 1, 2, 'credit', '240.000', '2017-06-20 20:35:59', 'BILL 0014', 'bill', 'receivings', 60, 'grn/billreceipt/60'),
(511, 10, 1, 2, 'debit', '60.000', '2017-06-20 20:35:59', 'BILL 0015', 'bill', 'receivings', 62, 'grn/billreceipt/62'),
(512, 60, 1, 2, 'credit', '60.000', '2017-06-20 20:35:59', 'BILL 0015', 'bill', 'receivings', 62, 'grn/billreceipt/62'),
(513, 10, 1, 2, 'debit', '100.000', '2017-06-20 20:35:59', 'BILL 0019', 'bill', 'receivings', 77, 'grn/billreceipt/77'),
(514, 60, 1, 2, 'credit', '100.000', '2017-06-20 20:35:59', 'BILL 0019', 'bill', 'receivings', 77, 'grn/billreceipt/77'),
(515, 10, 1, 2, 'debit', '50.000', '2017-06-20 20:35:59', 'BILL 0026', 'bill', 'receivings', 78, 'grn/billreceipt/78'),
(516, 60, 1, 2, 'credit', '50.000', '2017-06-20 20:35:59', 'BILL 0026', 'bill', 'receivings', 78, 'grn/billreceipt/78'),
(517, 10, 1, 2, 'debit', '25.000', '2017-06-20 20:35:59', 'BILL 0024', 'bill', 'receivings', 79, 'grn/billreceipt/79'),
(518, 60, 1, 2, 'credit', '25.000', '2017-06-20 20:35:59', 'BILL 0024', 'bill', 'receivings', 79, 'grn/billreceipt/79'),
(519, 10, 1, 2, 'debit', '50.000', '2017-06-20 20:35:59', 'BILL 0023', 'bill', 'receivings', 81, 'grn/billreceipt/81'),
(520, 60, 1, 2, 'credit', '50.000', '2017-06-20 20:35:59', 'BILL 0023', 'bill', 'receivings', 81, 'grn/billreceipt/81'),
(521, 10, 1, 2, 'debit', '300.000', '2017-06-20 20:35:59', 'BILL 0022', 'bill', 'receivings', 86, 'grn/billreceipt/86'),
(522, 60, 1, 2, 'credit', '300.000', '2017-06-20 20:35:59', 'BILL 0022', 'bill', 'receivings', 86, 'grn/billreceipt/86'),
(523, 9, 1, 2, 'credit', '250.000', '2017-06-20 20:44:29', 'REQ 0006', 'REQ', 'receivings', 89, 'grn/receipt/89'),
(524, 18, 1, 2, 'debit', '250.000', '2017-06-20 20:44:29', 'REQ 0006', 'REQ', 'receivings', 89, 'grn/receipt/89'),
(525, 9, 1, 6, 'debit', '0.000', '2017-06-21 11:54:10', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(526, 22, 1, 6, 'credit', '0.000', '2017-06-21 11:54:10', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(527, 9, 1, 8, 'debit', '0.000', '2017-06-21 11:54:10', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(528, 22, 1, 8, 'credit', '0.000', '2017-06-21 11:54:10', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(529, 9, 1, 5, 'debit', '0.000', '2017-06-21 11:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(530, 22, 1, 5, 'credit', '0.000', '2017-06-21 11:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(531, 9, 1, 4, 'debit', '0.000', '2017-06-21 11:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(532, 22, 1, 4, 'credit', '0.000', '2017-06-21 11:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(533, 9, 1, 2, 'debit', '0.000', '2017-06-21 11:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(534, 22, 1, 2, 'credit', '0.000', '2017-06-21 11:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(535, 9, 1, 3, 'debit', '0.000', '2017-06-21 11:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(536, 22, 1, 3, 'credit', '0.000', '2017-06-21 11:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(537, 9, 1, 6, 'debit', '1800.000', '2017-06-21 11:57:35', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(538, 22, 1, 6, 'credit', '1800.000', '2017-06-21 11:57:35', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(539, 9, 1, 8, 'debit', '0.000', '2017-06-21 11:57:35', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(540, 22, 1, 8, 'credit', '0.000', '2017-06-21 11:57:36', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(541, 9, 1, 5, 'debit', '0.000', '2017-06-21 11:57:36', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(542, 22, 1, 5, 'credit', '0.000', '2017-06-21 11:57:36', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(543, 9, 1, 4, 'debit', '0.000', '2017-06-21 11:57:36', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(544, 22, 1, 4, 'credit', '0.000', '2017-06-21 11:57:36', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(545, 9, 1, 2, 'debit', '2280.000', '2017-06-21 11:57:36', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(546, 22, 1, 2, 'credit', '2280.000', '2017-06-21 11:57:36', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(547, 9, 1, 3, 'debit', '0.000', '2017-06-21 11:57:36', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(548, 22, 1, 3, 'credit', '0.000', '2017-06-21 11:57:36', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(549, 9, 1, 6, 'debit', '1800.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(550, 22, 1, 6, 'credit', '1800.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(551, 9, 1, 8, 'debit', '0.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(552, 22, 1, 8, 'credit', '0.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(553, 9, 1, 5, 'debit', '0.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(554, 22, 1, 5, 'credit', '0.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(555, 9, 1, 4, 'debit', '0.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(556, 22, 1, 4, 'credit', '0.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(557, 9, 1, 2, 'debit', '2280.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(558, 22, 1, 2, 'credit', '2280.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(559, 9, 1, 3, 'debit', '0.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(560, 22, 1, 3, 'credit', '0.000', '2017-06-21 11:58:15', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(561, 9, 1, 6, 'debit', '1800.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(562, 22, 1, 6, 'credit', '1800.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(563, 9, 1, 8, 'debit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(564, 22, 1, 8, 'credit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(565, 9, 1, 5, 'debit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(566, 22, 1, 5, 'credit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(567, 9, 1, 4, 'debit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(568, 22, 1, 4, 'credit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(569, 9, 1, 2, 'debit', '2280.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(570, 22, 1, 2, 'credit', '2280.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(571, 9, 1, 3, 'debit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(572, 22, 1, 3, 'credit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(573, 9, 1, 6, 'debit', '1800.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(574, 22, 1, 6, 'credit', '1800.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(575, 9, 1, 8, 'debit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(576, 22, 1, 8, 'credit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(577, 9, 1, 5, 'debit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(578, 22, 1, 5, 'credit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(579, 9, 1, 4, 'debit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(580, 22, 1, 4, 'credit', '0.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(581, 9, 1, 2, 'debit', '2280.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(582, 22, 1, 2, 'credit', '2280.000', '2017-06-21 12:13:42', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(583, 9, 1, 3, 'debit', '0.000', '2017-06-21 12:13:43', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(584, 22, 1, 3, 'credit', '0.000', '2017-06-21 12:13:43', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(585, 9, 1, 3, 'credit', '0.000', '2017-06-21 12:15:36', 'REQ 0007', 'REQ', 'receivings', 91, 'grn/receipt/91'),
(586, 18, 1, 3, 'debit', '0.000', '2017-06-21 12:15:36', 'REQ 0007', 'REQ', 'receivings', 91, 'grn/receipt/91'),
(587, 18, 1, 6, 'credit', '0.000', '2017-06-21 12:17:32', 'SOC 0003', 'SOC', 'receivings', 92, 'grn/receipt/92'),
(588, 9, 1, 6, 'debit', '0.000', '2017-06-21 12:17:32', 'SOC 0003', 'SOC', 'receivings', 92, 'grn/receipt/92'),
(589, 9, 1, 2, 'credit', '570.000', '2017-06-21 12:20:25', 'REQ 0008', 'REQ', 'receivings', 94, 'grn/receipt/94'),
(590, 18, 1, 2, 'debit', '570.000', '2017-06-21 12:20:25', 'REQ 0008', 'REQ', 'receivings', 94, 'grn/receipt/94'),
(591, 18, 1, 6, 'credit', '570.000', '2017-06-21 12:20:41', 'SOC 0004', 'SOC', 'receivings', 95, 'grn/receipt/95'),
(592, 9, 1, 6, 'debit', '570.000', '2017-06-21 12:20:41', 'SOC 0004', 'SOC', 'receivings', 95, 'grn/receipt/95'),
(593, 9, 1, 6, 'debit', '2880.000', '2017-06-21 12:23:29', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(594, 22, 1, 6, 'credit', '2880.000', '2017-06-21 12:23:29', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/6'),
(595, 9, 1, 8, 'debit', '0.000', '2017-06-21 12:23:29', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(596, 22, 1, 8, 'credit', '0.000', '2017-06-21 12:23:29', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/8'),
(597, 9, 1, 5, 'debit', '0.000', '2017-06-21 12:23:30', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(598, 22, 1, 5, 'credit', '0.000', '2017-06-21 12:23:30', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/5'),
(599, 9, 1, 4, 'debit', '0.000', '2017-06-21 12:23:30', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(600, 22, 1, 4, 'credit', '0.000', '2017-06-21 12:23:30', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/4'),
(601, 9, 1, 2, 'debit', '1710.000', '2017-06-21 12:23:30', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(602, 22, 1, 2, 'credit', '1710.000', '2017-06-21 12:23:30', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/2'),
(603, 9, 1, 3, 'debit', '0.000', '2017-06-21 12:23:30', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(604, 22, 1, 3, 'credit', '0.000', '2017-06-21 12:23:30', 'Manual Edit of Quantity', 'items_manually', 'items', 17, 'inventories/details17/3'),
(605, 9, 1, 6, 'debit', '1260.000', '2017-06-21 12:42:17', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/6'),
(606, 22, 1, 6, 'credit', '1260.000', '2017-06-21 12:42:17', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/6'),
(607, 9, 1, 8, 'debit', '0.000', '2017-06-21 12:42:17', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/8'),
(608, 22, 1, 8, 'credit', '0.000', '2017-06-21 12:42:17', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/8'),
(609, 9, 1, 5, 'debit', '0.000', '2017-06-21 12:42:17', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/5'),
(610, 22, 1, 5, 'credit', '0.000', '2017-06-21 12:42:17', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/5'),
(611, 9, 1, 4, 'debit', '0.000', '2017-06-21 12:42:17', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/4'),
(612, 22, 1, 4, 'credit', '0.000', '2017-06-21 12:42:18', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/4'),
(613, 9, 1, 2, 'debit', '690.000', '2017-06-21 12:42:18', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/2'),
(614, 22, 1, 2, 'credit', '690.000', '2017-06-21 12:42:18', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/2'),
(615, 9, 1, 3, 'debit', '0.000', '2017-06-21 12:42:18', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/3'),
(616, 22, 1, 3, 'credit', '0.000', '2017-06-21 12:42:18', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/3'),
(617, 9, 1, 2, 'credit', '345.000', '2017-06-21 12:43:24', 'REQ 0009', 'REQ', 'receivings', 97, 'grn/receipt/97'),
(618, 18, 1, 2, 'debit', '345.000', '2017-06-21 12:43:24', 'REQ 0009', 'REQ', 'receivings', 97, 'grn/receipt/97'),
(619, 18, 1, 6, 'credit', '115.000', '2017-06-21 12:44:32', 'SOC 0005', 'SOC', 'receivings', 98, 'grn/receipt/98'),
(620, 9, 1, 6, 'debit', '115.000', '2017-06-21 12:44:32', 'SOC 0005', 'SOC', 'receivings', 98, 'grn/receipt/98'),
(621, 9, 1, 6, 'debit', '1575.000', '2017-06-21 12:46:41', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/6'),
(622, 22, 1, 6, 'credit', '1575.000', '2017-06-21 12:46:41', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/6'),
(623, 9, 1, 8, 'debit', '0.000', '2017-06-21 12:46:41', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/8'),
(624, 22, 1, 8, 'credit', '0.000', '2017-06-21 12:46:41', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/8'),
(625, 9, 1, 5, 'debit', '0.000', '2017-06-21 12:46:41', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/5'),
(626, 22, 1, 5, 'credit', '0.000', '2017-06-21 12:46:41', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/5'),
(627, 9, 1, 4, 'debit', '0.000', '2017-06-21 12:46:41', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/4'),
(628, 22, 1, 4, 'credit', '0.000', '2017-06-21 12:46:41', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/4'),
(629, 9, 1, 2, 'debit', '1380.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/2'),
(630, 22, 1, 2, 'credit', '1380.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/2'),
(631, 9, 1, 3, 'debit', '0.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/3'),
(632, 22, 1, 3, 'credit', '0.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/3'),
(633, 9, 1, 6, 'debit', '1575.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/6'),
(634, 22, 1, 6, 'credit', '1575.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/6'),
(635, 9, 1, 8, 'debit', '0.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/8'),
(636, 22, 1, 8, 'credit', '0.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/8'),
(637, 9, 1, 5, 'debit', '0.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/5'),
(638, 22, 1, 5, 'credit', '0.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/5'),
(639, 9, 1, 4, 'debit', '0.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/4'),
(640, 22, 1, 4, 'credit', '0.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/4'),
(641, 9, 1, 2, 'debit', '1380.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/2'),
(642, 22, 1, 2, 'credit', '1380.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/2'),
(643, 9, 1, 3, 'debit', '0.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/3'),
(644, 22, 1, 3, 'credit', '0.000', '2017-06-21 12:46:42', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/3'),
(645, 9, 1, 2, 'credit', '460.000', '2017-06-21 12:48:02', 'REQ 0010', 'REQ', 'receivings', 100, 'grn/receipt/100'),
(646, 18, 1, 2, 'debit', '460.000', '2017-06-21 12:48:02', 'REQ 0010', 'REQ', 'receivings', 100, 'grn/receipt/100'),
(647, 18, 1, 6, 'credit', '460.000', '2017-06-21 12:48:41', 'SOC 0006', 'SOC', 'receivings', 101, 'grn/receipt/101'),
(648, 9, 1, 6, 'debit', '460.000', '2017-06-21 12:48:41', 'SOC 0006', 'SOC', 'receivings', 101, 'grn/receipt/101'),
(649, 9, 1, 6, 'debit', '1995.000', '2017-06-21 12:54:10', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/6'),
(650, 22, 1, 6, 'credit', '1995.000', '2017-06-21 12:54:10', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/6'),
(651, 9, 1, 8, 'debit', '0.000', '2017-06-21 12:54:10', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/8'),
(652, 22, 1, 8, 'credit', '0.000', '2017-06-21 12:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/8'),
(653, 9, 1, 5, 'debit', '0.000', '2017-06-21 12:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/5'),
(654, 22, 1, 5, 'credit', '0.000', '2017-06-21 12:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/5'),
(655, 9, 1, 4, 'debit', '0.000', '2017-06-21 12:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/4'),
(656, 22, 1, 4, 'credit', '0.000', '2017-06-21 12:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/4'),
(657, 9, 1, 2, 'debit', '920.000', '2017-06-21 12:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/2'),
(658, 22, 1, 2, 'credit', '920.000', '2017-06-21 12:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/2'),
(659, 9, 1, 3, 'debit', '0.000', '2017-06-21 12:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/3'),
(660, 22, 1, 3, 'credit', '0.000', '2017-06-21 12:54:11', 'Manual Edit of Quantity', 'items_manually', 'items', 18, 'inventories/details18/3'),
(661, 9, 1, 2, 'credit', '950.000', '2017-06-21 13:29:00', 'REQ 0011', 'REQ', 'receivings', 104, 'grn/receipt/104'),
(662, 18, 1, 2, 'debit', '950.000', '2017-06-21 13:29:00', 'REQ 0011', 'REQ', 'receivings', 104, 'grn/receipt/104'),
(663, 18, 1, 6, 'credit', '950.000', '2017-06-21 13:29:32', 'SOC 0007', 'SOC', 'receivings', 105, 'grn/receipt/105'),
(664, 9, 1, 6, 'debit', '950.000', '2017-06-21 13:29:32', 'SOC 0007', 'SOC', 'receivings', 105, 'grn/receipt/105'),
(665, 9, 1, 2, 'debit', '1500.000', '2017-06-21 13:45:22', 'BILL 0028', 'grn', 'receivings', 108, 'grn/receipt/108'),
(666, 10, 1, 2, 'credit', '1500.000', '2017-06-21 13:45:22', 'BILL 0028', 'grn', 'receivings', 108, 'grn/receipt/108'),
(667, 10, 1, 2, 'debit', '1500.000', '2017-06-21 13:46:06', 'BILL 0028', 'bill', 'receivings', 108, 'grn/billreceipt/108'),
(668, 60, 1, 2, 'credit', '1500.000', '2017-06-21 13:46:06', 'BILL 0028', 'bill', 'receivings', 108, 'grn/billreceipt/108'),
(669, 9, 1, 6, 'debit', '16000.000', '2017-06-21 13:48:50', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/6'),
(670, 22, 1, 6, 'credit', '16000.000', '2017-06-21 13:48:50', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/6'),
(671, 9, 1, 8, 'debit', '0.000', '2017-06-21 13:48:50', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/8'),
(672, 22, 1, 8, 'credit', '0.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/8'),
(673, 9, 1, 5, 'debit', '10000.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/5'),
(674, 22, 1, 5, 'credit', '10000.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/5'),
(675, 9, 1, 4, 'debit', '0.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/4'),
(676, 22, 1, 4, 'credit', '0.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/4'),
(677, 9, 1, 2, 'debit', '22800.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/2'),
(678, 22, 1, 2, 'credit', '22800.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/2'),
(679, 9, 1, 3, 'debit', '0.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/3'),
(680, 22, 1, 3, 'credit', '0.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/3'),
(681, 9, 1, 6, 'debit', '16000.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/6'),
(682, 22, 1, 6, 'credit', '16000.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/6'),
(683, 9, 1, 8, 'debit', '0.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/8'),
(684, 22, 1, 8, 'credit', '0.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/8'),
(685, 9, 1, 5, 'debit', '10000.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/5'),
(686, 22, 1, 5, 'credit', '10000.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/5'),
(687, 9, 1, 4, 'debit', '0.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/4'),
(688, 22, 1, 4, 'credit', '0.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/4'),
(689, 9, 1, 2, 'debit', '22800.000', '2017-06-21 13:48:51', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/2'),
(690, 22, 1, 2, 'credit', '22800.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/2'),
(691, 9, 1, 3, 'debit', '0.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/3'),
(692, 22, 1, 3, 'credit', '0.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/3'),
(693, 9, 1, 6, 'debit', '16000.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/6'),
(694, 22, 1, 6, 'credit', '16000.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/6'),
(695, 9, 1, 8, 'debit', '0.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/8'),
(696, 22, 1, 8, 'credit', '0.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/8'),
(697, 9, 1, 5, 'debit', '10000.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/5'),
(698, 22, 1, 5, 'credit', '10000.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/5'),
(699, 9, 1, 4, 'debit', '0.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/4'),
(700, 22, 1, 4, 'credit', '0.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/4'),
(701, 9, 1, 2, 'debit', '22800.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/2'),
(702, 22, 1, 2, 'credit', '22800.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/2'),
(703, 9, 1, 3, 'debit', '0.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/3'),
(704, 22, 1, 3, 'credit', '0.000', '2017-06-21 13:48:52', 'Manual Edit of Quantity', 'items_manually', 'items', 13, 'inventories/details13/3'),
(705, 9, 1, 2, 'credit', '950.000', '2017-06-21 13:50:23', 'REQ 0012', 'REQ', 'receivings', 111, 'grn/receipt/111'),
(706, 18, 1, 2, 'debit', '950.000', '2017-06-21 13:50:23', 'REQ 0012', 'REQ', 'receivings', 111, 'grn/receipt/111'),
(707, 18, 1, 5, 'credit', '950.000', '2017-06-21 13:50:59', 'SOC 0008', 'SOC', 'receivings', 112, 'grn/receipt/112'),
(708, 9, 1, 5, 'debit', '950.000', '2017-06-21 13:50:59', 'SOC 0008', 'SOC', 'receivings', 112, 'grn/receipt/112'),
(709, 9, 1, 6, 'debit', '0.000', '2017-06-21 14:02:59', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/6'),
(710, 22, 1, 6, 'credit', '0.000', '2017-06-21 14:02:59', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/6'),
(711, 9, 1, 8, 'debit', '0.000', '2017-06-21 14:02:59', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/8'),
(712, 22, 1, 8, 'credit', '0.000', '2017-06-21 14:02:59', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/8'),
(713, 9, 1, 5, 'debit', '0.000', '2017-06-21 14:03:00', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/5'),
(714, 22, 1, 5, 'credit', '0.000', '2017-06-21 14:03:00', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/5'),
(715, 9, 1, 4, 'debit', '0.000', '2017-06-21 14:03:00', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/4'),
(716, 22, 1, 4, 'credit', '0.000', '2017-06-21 14:03:00', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/4'),
(717, 9, 1, 2, 'debit', '0.000', '2017-06-21 14:03:00', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/2'),
(718, 22, 1, 2, 'credit', '0.000', '2017-06-21 14:03:00', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/2'),
(719, 9, 1, 3, 'debit', '0.000', '2017-06-21 14:03:00', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/3'),
(720, 22, 1, 3, 'credit', '0.000', '2017-06-21 14:03:00', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/3'),
(721, 9, 1, 6, 'debit', '171000.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/6'),
(722, 22, 1, 6, 'credit', '171000.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/6'),
(723, 9, 1, 8, 'debit', '0.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/8'),
(724, 22, 1, 8, 'credit', '0.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/8'),
(725, 9, 1, 5, 'debit', '171000.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/5'),
(726, 22, 1, 5, 'credit', '171000.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/5'),
(727, 9, 1, 4, 'debit', '0.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/4'),
(728, 22, 1, 4, 'credit', '0.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/4'),
(729, 9, 1, 2, 'debit', '0.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/2'),
(730, 22, 1, 2, 'credit', '0.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/2'),
(731, 9, 1, 3, 'debit', '195000.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/3'),
(732, 22, 1, 3, 'credit', '195000.000', '2017-06-21 14:19:55', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/3'),
(733, 9, 1, 6, 'debit', '171000.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/6'),
(734, 22, 1, 6, 'credit', '171000.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/6'),
(735, 9, 1, 8, 'debit', '0.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/8'),
(736, 22, 1, 8, 'credit', '0.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/8'),
(737, 9, 1, 5, 'debit', '171000.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/5'),
(738, 22, 1, 5, 'credit', '171000.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/5'),
(739, 9, 1, 4, 'debit', '0.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/4'),
(740, 22, 1, 4, 'credit', '0.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/4'),
(741, 9, 1, 2, 'debit', '0.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/2'),
(742, 22, 1, 2, 'credit', '0.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/2'),
(743, 9, 1, 3, 'debit', '195000.000', '2017-06-21 14:20:28', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/3'),
(744, 22, 1, 3, 'credit', '195000.000', '2017-06-21 14:20:29', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/3');
INSERT INTO `ospos_account_trans` (`id`, `account_id`, `employee_id`, `location_id`, `trans_type`, `amount`, `trans_date`, `reference`, `reference_type`, `reference_table`, `reference_id`, `url`) VALUES
(745, 9, 1, 6, 'debit', '9200.000', '2017-06-22 11:42:00', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/6'),
(746, 22, 1, 6, 'credit', '9200.000', '2017-06-22 11:42:00', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/6'),
(747, 9, 1, 8, 'debit', '0.000', '2017-06-22 11:42:00', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/8'),
(748, 22, 1, 8, 'credit', '0.000', '2017-06-22 11:42:00', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/8'),
(749, 9, 1, 5, 'debit', '9200.000', '2017-06-22 11:42:00', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/5'),
(750, 22, 1, 5, 'credit', '9200.000', '2017-06-22 11:42:00', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/5'),
(751, 9, 1, 4, 'debit', '0.000', '2017-06-22 11:42:00', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/4'),
(752, 22, 1, 4, 'credit', '0.000', '2017-06-22 11:42:00', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/4'),
(753, 9, 1, 2, 'debit', '11750.000', '2017-06-22 11:42:01', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/2'),
(754, 22, 1, 2, 'credit', '11750.000', '2017-06-22 11:42:01', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/2'),
(755, 9, 1, 3, 'debit', '0.000', '2017-06-22 11:42:01', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/3'),
(756, 22, 1, 3, 'credit', '0.000', '2017-06-22 11:42:01', 'Manual Edit of Quantity', 'items_manually', 'items', 20, 'inventories/details20/3'),
(757, 9, 1, 6, 'debit', '171000.000', '2017-06-22 12:18:22', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/6'),
(758, 22, 1, 6, 'credit', '171000.000', '2017-06-22 12:18:22', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/6'),
(759, 9, 1, 8, 'debit', '0.000', '2017-06-22 12:18:22', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/8'),
(760, 22, 1, 8, 'credit', '0.000', '2017-06-22 12:18:22', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/8'),
(761, 9, 1, 5, 'debit', '171000.000', '2017-06-22 12:18:22', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/5'),
(762, 22, 1, 5, 'credit', '171000.000', '2017-06-22 12:18:22', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/5'),
(763, 9, 1, 4, 'debit', '0.000', '2017-06-22 12:18:22', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/4'),
(764, 22, 1, 4, 'credit', '0.000', '2017-06-22 12:18:22', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/4'),
(765, 9, 1, 2, 'debit', '0.000', '2017-06-22 12:18:22', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/2'),
(766, 22, 1, 2, 'credit', '0.000', '2017-06-22 12:18:22', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/2'),
(767, 9, 1, 3, 'debit', '195000.000', '2017-06-22 12:18:23', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/3'),
(768, 22, 1, 3, 'credit', '195000.000', '2017-06-22 12:18:23', 'Manual Edit of Quantity', 'items_manually', 'items', 19, 'inventories/details19/3'),
(769, 9, 1, 3, 'credit', '0.000', '2017-06-23 18:29:58', 'REQ 0013', 'REQ', 'receivings', 118, 'grn/receipt/118'),
(770, 18, 1, 3, 'debit', '0.000', '2017-06-23 18:29:58', 'REQ 0013', 'REQ', 'receivings', 118, 'grn/receipt/118'),
(771, 9, 1, 2, 'credit', '525.000', '2017-06-23 18:31:11', 'REQ 0014', 'REQ', 'receivings', 119, 'grn/receipt/119'),
(772, 18, 1, 2, 'debit', '525.000', '2017-06-23 18:31:11', 'REQ 0014', 'REQ', 'receivings', 119, 'grn/receipt/119'),
(773, 9, 1, 2, 'credit', '60.000', '2017-06-23 18:48:10', 'REQ 0015', 'REQ', 'receivings', 121, 'grn/receipt/121'),
(774, 18, 1, 2, 'debit', '60.000', '2017-06-23 18:48:10', 'REQ 0015', 'REQ', 'receivings', 121, 'grn/receipt/121'),
(775, 18, 1, 6, 'credit', '40.000', '2017-06-23 18:49:01', 'SOC 0009', 'SOC', 'receivings', 122, 'grn/receipt/122'),
(776, 9, 1, 6, 'debit', '40.000', '2017-06-23 18:49:01', 'SOC 0009', 'SOC', 'receivings', 122, 'grn/receipt/122'),
(777, 9, 1, 2, 'credit', '2850.000', '2017-06-23 20:59:14', 'REQ 0016', 'REQ', 'receivings', 124, 'grn/receipt/124'),
(778, 18, 1, 2, 'debit', '2850.000', '2017-06-23 20:59:14', 'REQ 0016', 'REQ', 'receivings', 124, 'grn/receipt/124'),
(779, 9, 1, 2, 'credit', '950.000', '2017-06-24 11:51:29', 'REQ 0017', 'REQ', 'receivings', 125, 'grn/receipt/125'),
(780, 18, 1, 2, 'debit', '950.000', '2017-06-24 11:51:29', 'REQ 0017', 'REQ', 'receivings', 125, 'grn/receipt/125'),
(781, 9, 1, 2, 'credit', '1900.000', '2017-06-24 12:00:26', 'REQ 0018', 'REQ', 'receivings', 126, 'grn/receipt/126'),
(782, 18, 1, 2, 'debit', '1900.000', '2017-06-24 12:00:26', 'REQ 0018', 'REQ', 'receivings', 126, 'grn/receipt/126'),
(783, 18, 1, 6, 'credit', '1900.000', '2017-06-24 12:01:22', 'SOC 0010', 'SOC', 'receivings', 127, 'grn/receipt/127'),
(784, 9, 1, 6, 'debit', '1900.000', '2017-06-24 12:01:22', 'SOC 0010', 'SOC', 'receivings', 127, 'grn/receipt/127'),
(785, 9, 1, 2, 'credit', '1900.000', '2017-06-24 12:03:03', 'REQ 0019', 'REQ', 'receivings', 128, 'grn/receipt/128'),
(786, 18, 1, 2, 'debit', '1900.000', '2017-06-24 12:03:03', 'REQ 0019', 'REQ', 'receivings', 128, 'grn/receipt/128'),
(787, 18, 1, 6, 'credit', '1900.000', '2017-06-24 12:03:36', 'SOC 0011', 'SOC', 'receivings', 129, 'grn/receipt/129'),
(788, 9, 1, 6, 'debit', '1900.000', '2017-06-24 12:03:36', 'SOC 0011', 'SOC', 'receivings', 129, 'grn/receipt/129'),
(789, 9, 1, 3, 'credit', '2000.000', '2017-06-24 12:11:57', 'REQ 0020', 'REQ', 'receivings', 131, 'grn/receipt/131'),
(790, 18, 1, 3, 'debit', '2000.000', '2017-06-24 12:11:57', 'REQ 0020', 'REQ', 'receivings', 131, 'grn/receipt/131'),
(791, 18, 1, 6, 'credit', '2000.000', '2017-06-24 14:33:48', 'SOC 0012', 'SOC', 'receivings', 132, 'grn/receipt/132'),
(792, 9, 1, 6, 'debit', '2000.000', '2017-06-24 14:33:48', 'SOC 0012', 'SOC', 'receivings', 132, 'grn/receipt/132'),
(793, 65, 1, 0, 'debit', '500.000', '2018-05-23 18:38:40', 'gfg', 'deposit', NULL, NULL, NULL),
(794, 20, 1, 0, 'credit', '500.000', '2018-05-23 18:38:40', 'gfg', 'deposit', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_app_config`
--

CREATE TABLE `ospos_app_config` (
  `key` varchar(50) NOT NULL,
  `value` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_app_config`
--

INSERT INTO `ospos_app_config` (`key`, `value`) VALUES
('address', 'Vientiane Prefecture, Laos'),
('barcode_content', 'number'),
('barcode_first_row', 'name'),
('barcode_font', '0'),
('barcode_font_size', '10'),
('barcode_generate_if_empty', '0'),
('barcode_height', '50'),
('barcode_num_in_row', '2'),
('barcode_page_cellspacing', '20'),
('barcode_page_width', '100'),
('barcode_quality', '100'),
('barcode_second_row', 'item_code'),
('barcode_third_row', 'unit_price'),
('barcode_type', 'Code39'),
('barcode_width', '250'),
('cash_decimals', '2'),
('cash_rounding_code', '0'),
('client_id', '0afd6c60-d8b5-41ff-9757-fe76a692a1bd'),
('company', 'Sokxay Mart'),
('company_logo', 'company_logo.png'),
('country_codes', 'us'),
('currency_decimals', '2'),
('currency_symbol', '$'),
('custom10_name', ''),
('custom1_name', ''),
('custom2_name', ''),
('custom3_name', ''),
('custom4_name', ''),
('custom5_name', ''),
('custom6_name', ''),
('custom7_name', ''),
('custom8_name', ''),
('custom9_name', ''),
('customer_reward_enable', ''),
('customer_sales_tax_support', '0'),
('dateformat', 'm/d/Y'),
('date_or_time_format', ''),
('default_origin_tax_code', ''),
('default_register_mode', 'sale_invoice'),
('default_sales_discount', '0'),
('default_tax_1_name', 'Laos at a standard rate'),
('default_tax_1_rate', '10'),
('default_tax_2_name', ''),
('default_tax_2_rate', ''),
('default_tax_category', 'Standard'),
('default_tax_rate', '8'),
('dinner_table_enable', 'dinner_table_enable'),
('email', 'changeme@example.com'),
('fax', ''),
('financial_year', '1'),
('giftcard_number', 'random'),
('invoice_default_comments', 'This is a default comment'),
('invoice_email_message', 'Dear $CU, In attachment the receipt for sale $INV'),
('invoice_enable', '1'),
('invoice_number_prefix', 'SOK '),
('language', 'english'),
('language_code', 'en'),
('last_used_invoice_number', '0'),
('last_used_quote_number', '3'),
('lines_per_page', '25'),
('line_sequence', '0'),
('mailpath', '/usr/sbin/sendmail'),
('msg_msg', ''),
('msg_pwd', ''),
('msg_src', ''),
('msg_uid', ''),
('notify_horizontal_position', 'center'),
('notify_vertical_position', 'bottom'),
('number_locale', 'en_US'),
('payment_options_order', 'cashdebitcredit'),
('phone', '+856 21 254 555'),
('print_bottom_margin', ''),
('print_footer', '0'),
('print_header', '0'),
('print_left_margin', ''),
('print_right_margin', ''),
('print_silently', '0'),
('print_top_margin', ''),
('protocol', 'mail'),
('quantity_decimals', '0'),
('receipt_show_company_name', '1'),
('receipt_show_description', '1'),
('receipt_show_serialnumber', '1'),
('receipt_show_taxes', '1'),
('receipt_show_total_discount', '1'),
('receipt_template', 'receipt_default'),
('receiving_calculate_average_price', '0'),
('recv_invoice_format', '$CO'),
('return_policy', 'Test'),
('sales_invoice_format', '$CO'),
('sales_quote_format', 'Q%y{QSEQ:6}'),
('smtp_crypto', 'ssl'),
('smtp_port', '465'),
('smtp_timeout', '5'),
('statistics', '1'),
('tax_decimals', '2'),
('tax_included', '0'),
('theme', 'flatly'),
('thousands_separator', 'thousands_separator'),
('timeformat', 'H:i:s'),
('timezone', 'Asia/Bangkok'),
('website', '');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_audit_trail`
--

CREATE TABLE `ospos_audit_trail` (
  `audit_trail_id` int(255) NOT NULL,
  `employee_id` int(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `location` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `ref_text` varchar(500) NOT NULL,
  `ref_id` varchar(500) NOT NULL,
  `ref_to` int(11) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_audit_trail`
--

INSERT INTO `ospos_audit_trail` (`audit_trail_id`, `employee_id`, `date_time`, `location`, `action`, `ref_text`, `ref_id`, `ref_to`, `url`) VALUES
(1, 1, '2017-05-30 14:16:16', 0, 'Update Item', '8789797777', '1', 0, 'items/save/1'),
(2, 1, '2017-05-30 14:16:26', 0, 'Update Item', 'D53563636', '2', 0, 'items/save/2'),
(3, 1, '2017-05-30 14:16:34', 0, 'Update Item', 'LB87979', '3', 0, 'items/save/3'),
(4, 1, '2017-05-30 14:16:42', 0, 'Update Item', 'MP43636363', '4', 0, 'items/save/4'),
(5, 1, '2017-05-30 14:16:50', 0, 'Update Item', 'PN879797', '5', 0, 'items/save/5'),
(6, 1, '2017-05-30 14:19:02', 0, 'New Item', 'TESTING', '6', 0, 'items/save'),
(7, 1, '2017-05-30 14:19:02', 6, 'Manual Edit of Quantity', '0', '6', 0, 'items/save'),
(8, 1, '2017-05-30 14:19:03', 8, 'Manual Edit of Quantity', '0', '6', 0, 'items/save'),
(9, 1, '2017-05-30 14:19:03', 5, 'Manual Edit of Quantity', '0', '6', 0, 'items/save'),
(10, 1, '2017-05-30 14:19:04', 4, 'Manual Edit of Quantity', '0', '6', 0, 'items/save'),
(11, 1, '2017-05-30 14:19:04', 2, 'Manual Edit of Quantity', '0', '6', 0, 'items/save'),
(12, 1, '2017-05-30 14:19:04', 3, 'Manual Edit of Quantity', '0', '6', 0, 'items/save'),
(13, 7, '2017-05-30 14:20:51', 0, 'PO Receiving', 'PO 0001', '1', 13, 'purchase_order/po_complete'),
(14, 7, '2017-05-30 14:21:48', 0, 'GRN Receiving', 'GRN 0001', '2', 13, 'grn/complete'),
(15, 7, '2017-05-30 14:25:48', 0, 'GRN Receiving', 'GRN 0002', '3', 13, 'grn/complete'),
(16, 7, '2017-05-30 14:26:03', 0, 'GRN Receiving', 'GRN 0003', '4', 13, 'grn/complete'),
(17, 10, '2017-05-30 14:31:24', 0, 'Stock Order Sent', 'SO 0001', '5', 3, 'stock_order/complete'),
(18, 7, '2017-05-30 14:32:00', 0, 'Supply stock', 'REQ 0001', '6', 3, 'requisition/complete'),
(19, 10, '2017-05-30 14:34:13', 0, 'SOC Receiving', 'SOC 0001', '7', 3, 'stockorder_check/complete'),
(20, 10, '2017-05-30 14:36:04', 0, 'Stock Order Sent', 'SO 0002', '8', 3, 'stock_order/complete'),
(21, 7, '2017-05-30 14:36:29', 0, 'Supply stock', 'REQ 0002', '9', 3, 'requisition/complete'),
(22, 1, '2017-05-30 14:36:49', 0, 'SOC Receiving', 'SOC 0002', '10', 3, 'stockorder_check/complete'),
(23, 7, '2017-05-30 14:38:46', 0, 'PO Receiving', 'PO 0002', '11', 15, 'purchase_order/po_complete'),
(24, 7, '2017-05-30 14:49:24', 0, 'GRN Receiving', 'GRN 0004', '12', 15, 'grn/complete'),
(25, 1, '2017-06-01 13:42:29', 0, 'PO Receiving', 'PO 0003', '13', 13, 'purchase_order/po_complete'),
(26, 1, '2017-06-01 13:43:55', 0, 'GRN Receiving', 'GRN 0005', '14', 13, 'grn/complete'),
(27, 1, '2017-06-01 14:02:30', 0, 'PO Receiving', 'PO 0004', '15', 13, 'purchase_order/po_complete'),
(28, 1, '2017-06-01 14:02:51', 0, 'GRN Receiving', 'GRN 0006', '16', 13, 'grn/complete'),
(29, 1, '2017-06-05 08:34:14', 0, 'Update Employee', '10', '10', 0, 'employees/save/10'),
(30, 1, '2017-06-05 08:34:18', 0, 'Update Employee', '8', '8', 0, 'employees/save/8'),
(31, 1, '2017-06-05 08:36:21', 0, 'Update Employee', '1', '1', 0, 'employees/save/1'),
(32, 1, '2017-06-05 08:36:32', 0, 'Update Employee', '1', '1', 0, 'employees/save/1'),
(33, 1, '2017-06-05 08:36:44', 0, 'Update Employee', '8', '8', 0, 'employees/save/8'),
(34, 1, '2017-06-05 12:10:01', 0, 'PO Receiving', 'PO 0005', '17', 13, 'purchase_order/po_complete'),
(35, 1, '2017-06-05 12:10:11', 0, 'GRN Receiving', 'GRN 0007', '18', 13, 'grn/complete'),
(36, 1, '2017-06-05 12:28:40', 0, 'PO Receiving', 'PO 0006', '19', 13, 'purchase_order/po_complete'),
(37, 1, '2017-06-06 14:52:08', 0, 'GRN Receiving', 'GRN 0008', '20', 13, 'grn/complete'),
(38, 1, '2017-06-09 06:23:57', 0, 'Update Employee', '1', '1', 0, 'employees/save/1'),
(39, 1, '2017-06-09 06:27:47', 0, 'Update Employee', '1', '1', 0, 'employees/save/1'),
(40, 1, '2017-06-12 11:09:26', 0, 'PO Receiving', 'PO 0007', '21', 13, 'purchase_order/po_complete'),
(41, 1, '2017-06-12 11:17:15', 0, 'Update Customer', '2', '2', 0, 'customers/save/2'),
(42, 1, '2017-06-12 11:17:41', 0, 'New Customer', '16', '16', 0, 'customers/save'),
(43, 1, '2017-06-12 11:24:42', 0, 'New Customer', '17', '17', 0, 'customers/save'),
(44, 1, '2017-06-12 11:50:49', 0, 'Update Employee', '1', '1', 0, 'employees/save/1'),
(45, 1, '2017-06-12 11:51:00', 0, 'Update Customer', '2', '2', 0, 'customers/save/2'),
(46, 1, '2017-06-12 12:47:24', 0, 'New Product', '', '7', 0, 'items/save'),
(47, 1, '2017-06-12 13:02:28', 0, 'PO Receiving', 'PO 0008', '22', 15, 'purchase_order/po_complete'),
(48, 1, '2017-06-12 13:02:59', 0, 'PO Receiving', 'PO 0009', '23', 14, 'purchase_order/po_complete'),
(49, 1, '2017-06-12 13:04:09', 0, 'PO Receiving', 'PO 0010', '24', 14, 'purchase_order/po_complete'),
(50, 1, '2017-06-12 13:04:59', 0, 'GRN Receiving', 'GRN 0009', '25', 13, 'grn/complete'),
(51, 1, '2017-06-12 13:06:31', 0, 'PO Receiving', 'PO 0011', '26', 11, 'purchase_order/po_complete'),
(52, 1, '2017-06-12 13:07:17', 0, 'PO Receiving', 'PO 0012', '27', 11, 'purchase_order/po_complete'),
(53, 1, '2017-06-12 13:09:20', 0, 'GRN Receiving', 'GRN 0010', '28', 15, 'grn/complete'),
(54, 1, '2017-06-12 13:11:28', 0, 'Stock Order Sent', 'SO 0003', '29', 3, 'stock_order/complete'),
(55, 1, '2017-06-12 13:11:53', 0, 'Stock Order Sent', 'SO 0004', '30', 3, 'stock_order/complete'),
(56, 1, '2017-06-12 13:13:07', 0, 'Stock Order Sent', 'SO 0005', '31', 3, 'stock_order/complete'),
(57, 1, '2017-06-12 13:14:10', 0, 'New Product', '', '8', 0, 'items/save'),
(58, 1, '2017-06-12 13:18:04', 0, 'Stock Order Sent', 'SO 0006', '32', 3, 'stock_order/complete'),
(59, 1, '2017-06-12 13:18:35', 0, 'Stock Order Sent', 'SO 0007', '33', 2, 'stock_order/complete'),
(60, 1, '2017-06-12 14:08:25', 0, 'New Product', '', '9', 0, 'items/save'),
(61, 1, '2017-06-12 14:30:54', 0, 'PO Receiving', 'PO 0013', '34', 11, 'purchase_order/po_complete'),
(62, 1, '2017-06-12 14:33:07', 0, 'New Supplier', '18', '18', 0, 'suppliers/save'),
(63, 1, '2017-06-12 14:34:12', 0, 'PO Receiving', 'PO 0014', '35', 14, 'purchase_order/po_complete'),
(64, 1, '2017-06-12 14:37:06', 0, 'GRN Receiving', 'GRN 0011', '36', 14, 'grn/complete'),
(65, 1, '2017-06-12 14:42:21', 0, 'GRN Receiving', 'GRN 0012', '37', 14, 'grn/complete'),
(66, 1, '2017-06-12 14:48:57', 0, 'Update Employee', '1', '1', 0, 'employees/save/1'),
(67, 1, '2017-06-12 14:50:07', 0, 'GRN Receiving', 'GRN 0013', '38', 14, 'grn/complete'),
(68, 1, '2017-06-12 14:51:01', 0, 'PO Receiving', 'PO 0015', '39', 14, 'purchase_order/po_complete'),
(69, 1, '2017-06-12 14:52:05', 0, 'GRN Receiving', 'GRN 0014', '40', 14, 'grn/complete'),
(70, 1, '2017-06-12 14:52:41', 0, 'GRN Receiving', 'GRN 0015', '41', 14, 'grn/complete'),
(71, 1, '2017-06-12 14:53:40', 0, 'Stock Order Sent', 'SO 0008', '42', 2, 'stock_order/complete'),
(72, 1, '2017-06-12 14:54:09', 0, 'Stock Order Sent', 'SO 0009', '43', 2, 'stock_order/complete'),
(73, 1, '2017-06-12 14:58:02', 0, 'Stock Order Sent', 'SO 0010', '44', 2, 'stock_order/complete'),
(74, 1, '2017-06-12 14:58:13', 0, 'Supply stock', 'REQ 0003', '45', 2, 'requisition/complete'),
(75, 1, '2017-06-12 15:09:49', 0, 'New Customer', '19', '19', 0, 'customers/save'),
(76, 1, '2017-06-12 15:27:54', 0, 'PO Receiving', 'PO 0016', '46', 15, 'purchase_order/po_complete'),
(77, 1, '2017-06-12 15:29:22', 0, 'GRN Receiving', 'GRN 0016', '47', 15, 'grn/complete'),
(78, 1, '2017-06-12 15:30:24', 0, 'GRN Receiving', 'GRN 0017', '48', 15, 'grn/complete'),
(79, 1, '2017-06-12 15:30:57', 0, 'GRN Receiving', 'GRN 0018', '49', 15, 'grn/complete'),
(80, 1, '2017-06-12 15:35:51', 0, 'Stock Order Sent', 'SO 0011', '50', 3, 'stock_order/complete'),
(81, 1, '2017-06-12 15:36:42', 0, 'Supply stock', 'REQ 0004', '51', 3, 'requisition/complete'),
(82, 1, '2017-06-12 15:38:35', 0, 'Supply stock', 'REQ 0005', '52', 3, 'requisition/complete'),
(83, 1, '2017-06-13 05:55:27', 0, 'New Customer', '20', '20', 0, 'customers/save'),
(84, 1, '2017-06-13 05:56:59', 0, 'Update Customer', '20', '20', 0, 'customers/save/20'),
(85, 1, '2017-06-13 05:57:47', 0, 'Update Customer', '20', '20', 0, 'customers/save/20'),
(86, 1, '2017-06-13 06:32:35', 0, 'Update Product', '8789797777', '1', 0, 'items/save/1'),
(87, 1, '2017-06-13 06:32:35', 6, 'Manual Edit of Quantity', '100', '1', 0, 'items/save/1'),
(88, 1, '2017-06-13 06:32:35', 4, 'Manual Edit of Quantity', '5', '1', 0, 'items/save/1'),
(89, 1, '2017-06-13 08:57:31', 0, 'New Customer', '21', '21', 0, 'customers/save'),
(90, 1, '2017-06-13 08:57:40', 0, 'Update Customer', '21', '21', 0, 'customers/save/21'),
(91, 1, '2017-06-13 08:58:04', 0, 'New Customer', '22', '22', 0, 'customers/save'),
(92, 1, '2017-06-13 09:03:07', 0, 'New Customer', '23', '23', 0, 'customers/save'),
(93, 1, '2017-06-13 09:03:27', 0, 'New Customer', '24', '24', 0, 'customers/save'),
(94, 1, '2017-06-13 09:06:51', 0, 'New Customer', '25', '25', 0, 'customers/save'),
(95, 1, '2017-06-13 09:11:00', 0, 'Update Customer', '2', '2', 0, 'customers/save/2'),
(96, 1, '2017-06-13 09:11:00', 0, 'Update Customer', '2', '2', 0, 'customers/save/2'),
(97, 1, '2017-06-13 11:09:08', 0, 'New Customer', '26', '26', 0, 'customers/save'),
(98, 1, '2017-06-13 11:18:17', 0, 'Update Customer', '26', '26', 0, 'customers/save/26'),
(99, 1, '2017-06-13 11:20:12', 0, 'Update Customer', '3', '3', 0, 'customers/save/3'),
(100, 1, '2017-06-13 11:20:42', 0, 'Update Customer', '3', '3', 0, 'customers/save/3'),
(101, 1, '2017-06-13 11:21:32', 0, 'Update Customer', '3', '3', 0, 'customers/save/3'),
(102, 1, '2017-06-13 11:31:37', 0, 'Update Customer', '3', '3', 0, 'customers/save/3'),
(103, 1, '2017-06-13 12:35:59', 0, 'Update Customer', '2', '2', 0, 'customers/save/2'),
(104, 1, '2017-06-13 13:19:10', 0, 'Update Customer', '26', '26', 0, 'customers/save/26'),
(105, 1, '2017-06-13 13:49:09', 0, 'Update Customer', '33', '33', 0, 'customers/save/33'),
(106, 1, '2017-06-13 14:11:29', 0, 'New Customer', '34', '34', 0, 'customers/save'),
(107, 1, '2017-06-13 14:11:43', 0, 'New Customer', '35', '35', 0, 'customers/save'),
(108, 1, '2017-06-14 05:54:42', 0, 'New Supplier', '36', '36', 0, 'suppliers/save'),
(109, 1, '2017-06-14 06:11:29', 0, 'PO Receiving', 'PO 0017', '53', 14, 'purchase_order/po_complete'),
(110, 1, '2017-06-14 06:16:24', 0, 'GRN Receiving', 'GRN 0019', '54', 14, 'grn/complete'),
(111, 1, '2017-06-14 06:33:32', 0, 'GRN Receiving', 'GRN 0020', '55', 14, 'grn/complete'),
(112, 1, '2017-06-14 12:50:26', 0, 'New Employee', '55', '55', 0, 'employees/save'),
(113, 1, '2017-06-14 13:01:57', 0, 'PO Receiving', 'PO 0018', '56', -1, 'purchase_order/po_complete'),
(114, 1, '2017-06-14 14:52:02', 0, 'Update Employee', '55', '55', 0, 'employees/save/55'),
(115, 55, '2017-06-14 14:54:03', 0, 'GRN Receiving', 'GRN 0021', '57', 11, 'grn/complete'),
(116, 55, '2017-06-14 14:54:35', 0, 'GRN Receiving', 'GRN 0022', '58', 11, 'grn/complete'),
(117, 1, '2017-06-15 08:17:36', 0, 'Update Employee', '55', '55', 0, 'employees/save/55'),
(118, 1, '2017-06-15 09:12:42', 0, 'Update Product', 'D53563636', '2', 0, 'items/save/2'),
(119, 1, '2017-06-15 09:12:43', 6, 'Manual Edit of Quantity', '2', '2', 0, 'items/save/2'),
(120, 1, '2017-06-15 09:12:43', 4, 'Manual Edit of Quantity', '1', '2', 0, 'items/save/2'),
(121, 1, '2017-06-15 09:15:37', 0, 'New Product', '', '10', 0, 'items/save'),
(122, 1, '2017-06-15 09:15:37', 6, 'Manual Edit of Quantity', '0', '10', 0, 'items/save'),
(123, 1, '2017-06-15 09:15:37', 8, 'Manual Edit of Quantity', '0', '10', 0, 'items/save'),
(124, 1, '2017-06-15 09:15:38', 5, 'Manual Edit of Quantity', '0', '10', 0, 'items/save'),
(125, 1, '2017-06-15 09:15:38', 4, 'Manual Edit of Quantity', '0', '10', 0, 'items/save'),
(126, 1, '2017-06-15 09:15:39', 2, 'Manual Edit of Quantity', '0', '10', 0, 'items/save'),
(127, 1, '2017-06-15 09:15:39', 3, 'Manual Edit of Quantity', '0', '10', 0, 'items/save'),
(128, 1, '2017-06-15 09:15:40', 0, 'New Product', '', '11', 0, 'items/save'),
(129, 1, '2017-06-15 09:15:40', 6, 'Manual Edit of Quantity', '0', '11', 0, 'items/save'),
(130, 1, '2017-06-15 09:15:40', 8, 'Manual Edit of Quantity', '0', '11', 0, 'items/save'),
(131, 1, '2017-06-15 09:15:40', 5, 'Manual Edit of Quantity', '0', '11', 0, 'items/save'),
(132, 1, '2017-06-15 09:15:41', 4, 'Manual Edit of Quantity', '0', '11', 0, 'items/save'),
(133, 1, '2017-06-15 09:15:41', 2, 'Manual Edit of Quantity', '0', '11', 0, 'items/save'),
(134, 1, '2017-06-15 09:15:41', 3, 'Manual Edit of Quantity', '0', '11', 0, 'items/save'),
(135, 1, '2017-06-15 09:18:05', 0, 'Update Product', '', '10', 0, 'items/save/10'),
(136, 1, '2017-06-15 09:18:05', 6, 'Manual Edit of Quantity', '5', '10', 0, 'items/save/10'),
(137, 1, '2017-06-15 09:18:05', 8, 'Manual Edit of Quantity', '6', '10', 0, 'items/save/10'),
(138, 1, '2017-06-15 09:18:06', 2, 'Manual Edit of Quantity', '20', '10', 0, 'items/save/10'),
(139, 1, '2017-06-15 09:18:06', 3, 'Manual Edit of Quantity', '21', '10', 0, 'items/save/10'),
(140, 1, '2017-06-15 09:18:07', 0, 'Update Product', '', '10', 0, 'items/save/10'),
(141, 1, '2017-06-15 09:18:43', 0, 'Update Product', 'Product Name Pen', '10', 0, 'items/save/10'),
(142, 1, '2017-06-15 09:19:13', 0, 'Update Product', 'P0024636723', '10', 0, 'items/save/10'),
(143, 1, '2017-06-15 09:19:48', 0, 'Update Product', 'P0024636723', '10', 0, 'items/save/10'),
(144, 1, '2017-06-15 11:20:17', 0, 'PO Receiving', 'PO 0019', '59', 12, 'purchase_order/po_complete'),
(145, 1, '2017-06-15 11:24:41', 0, 'GRN Receiving', 'GRN 0023', '60', 12, 'grn/complete'),
(146, 1, '2017-06-15 12:05:21', 0, 'PO Receiving', 'PO 0020', '61', 12, 'purchase_order/po_complete'),
(147, 1, '2017-06-15 12:05:59', 0, 'GRN Receiving', 'GRN 0024', '62', 12, 'grn/complete'),
(148, 1, '2017-06-15 12:42:26', 0, 'Update Product', 'P0024636723', '10', 0, 'items/save/10'),
(149, 1, '2017-06-15 12:44:26', 0, 'New Product', 'Product10001', '12', 0, 'items/save'),
(150, 1, '2017-06-15 12:44:26', 6, 'Manual Edit of Quantity', '0', '12', 0, 'items/save'),
(151, 1, '2017-06-15 12:44:27', 8, 'Manual Edit of Quantity', '0', '12', 0, 'items/save'),
(152, 1, '2017-06-15 12:44:27', 5, 'Manual Edit of Quantity', '0', '12', 0, 'items/save'),
(153, 1, '2017-06-15 12:44:28', 4, 'Manual Edit of Quantity', '0', '12', 0, 'items/save'),
(154, 1, '2017-06-15 12:44:28', 2, 'Manual Edit of Quantity', '0', '12', 0, 'items/save'),
(155, 1, '2017-06-15 12:44:28', 3, 'Manual Edit of Quantity', '0', '12', 0, 'items/save'),
(156, 1, '2017-06-15 12:46:30', 0, 'Update Product', 'Product10001', '12', 0, 'items/save/12'),
(157, 1, '2017-06-15 12:46:31', 0, 'Update Product', 'Product10001', '12', 0, 'items/save/12'),
(158, 1, '2017-06-15 12:48:34', 0, 'Update Product', 'Product10001', '12', 0, 'items/save/12'),
(159, 1, '2017-06-15 12:48:34', 6, 'Manual Edit of Quantity', '10', '12', 0, 'items/save/12'),
(160, 1, '2017-06-15 12:48:34', 2, 'Manual Edit of Quantity', '5', '12', 0, 'items/save/12'),
(161, 1, '2017-06-15 14:34:36', 0, 'New Product', 'PO 00034', '13', 0, 'items/save'),
(162, 1, '2017-06-15 14:34:36', 6, 'Manual Edit of Quantity', '115', '13', 0, 'items/save'),
(163, 1, '2017-06-15 14:34:37', 8, 'Manual Edit of Quantity', '0', '13', 0, 'items/save'),
(164, 1, '2017-06-15 14:34:37', 5, 'Manual Edit of Quantity', '0', '13', 0, 'items/save'),
(165, 1, '2017-06-15 14:34:37', 4, 'Manual Edit of Quantity', '0', '13', 0, 'items/save'),
(166, 1, '2017-06-15 14:34:37', 2, 'Manual Edit of Quantity', '0', '13', 0, 'items/save'),
(167, 1, '2017-06-15 14:34:37', 3, 'Manual Edit of Quantity', '0', '13', 0, 'items/save'),
(168, 1, '2017-06-15 14:36:21', 0, 'Update Product', 'PO 00034', '13', 0, 'items/save/13'),
(169, 1, '2017-06-15 14:36:21', 6, 'Manual Edit of Quantity', '-100', '13', 0, 'items/save/13'),
(170, 1, '2017-06-15 14:36:21', 2, 'Manual Edit of Quantity', '12', '13', 0, 'items/save/13'),
(171, 1, '2017-06-15 14:46:20', 0, 'GRN Receiving', 'GRN 0025', '63', 11, 'grn/complete'),
(172, 1, '2017-06-16 07:46:26', 0, 'PO Receiving', 'PO 0021', '64', 15, 'purchase_order/po_complete'),
(173, 1, '2017-06-16 07:57:42', 0, 'PO Receiving', 'PO 0022', '65', 15, 'purchase_order/po_complete'),
(174, 1, '2017-06-16 08:13:47', 0, 'GRN Receiving', 'GRN 0026', '66', 11, 'grn/complete'),
(175, 1, '2017-06-16 09:12:06', 0, 'PO Receiving', 'PO 0023', '67', -1, 'purchase_order/po_complete'),
(176, 1, '2017-06-16 09:25:23', 0, 'PO Receiving', 'PO 0024', '68', 13, 'purchase_order/po_complete'),
(177, 1, '2017-06-16 09:32:33', 0, 'Update Employee', '55', '55', 0, 'employees/save/55'),
(178, 55, '2017-06-16 09:34:15', 0, 'PO Receiving', 'PO 0025', '69', 14, 'purchase_order/po_complete'),
(179, 55, '2017-06-16 09:35:24', 0, 'PO Receiving', 'PO 0026', '70', 12, 'purchase_order/po_complete'),
(180, 1, '2017-06-16 11:34:25', 0, 'PO Receiving', 'PO 0027', '71', 11, 'purchase_order/po_complete'),
(181, 1, '2017-06-16 12:10:54', 0, 'PO Receiving', 'PO 0028', '72', 11, 'purchase_order/po_complete'),
(182, 1, '2017-06-16 14:54:25', 0, 'PO Receiving', 'PO 0029', '73', 11, 'purchase_order/po_complete'),
(183, 1, '2017-06-19 07:25:22', 0, 'Update Product', '8789797777', '1', 0, 'items/save/1'),
(184, 1, '2017-06-19 07:25:22', 6, 'Manual Edit of Quantity', '1', '1', 0, 'items/save/1'),
(185, 1, '2017-06-19 07:32:19', 0, 'New Product', '978-1-4028-9462-6', '14', 0, 'items/save'),
(186, 1, '2017-06-19 07:32:19', 6, 'Manual Edit of Quantity', '5', '14', 0, 'items/save'),
(187, 1, '2017-06-19 07:32:19', 8, 'Manual Edit of Quantity', '6', '14', 0, 'items/save'),
(188, 1, '2017-06-19 07:32:19', 5, 'Manual Edit of Quantity', '0', '14', 0, 'items/save'),
(189, 1, '2017-06-19 07:32:20', 4, 'Manual Edit of Quantity', '0', '14', 0, 'items/save'),
(190, 1, '2017-06-19 07:32:20', 2, 'Manual Edit of Quantity', '5', '14', 0, 'items/save'),
(191, 1, '2017-06-19 07:32:20', 3, 'Manual Edit of Quantity', '0', '14', 0, 'items/save'),
(192, 1, '2017-06-19 07:32:39', 0, 'Update Product', '978-1-4028-9462-6', '14', 0, 'items/save/14'),
(193, 1, '2017-06-19 07:35:00', 0, 'PO Receiving', 'PO 0030', '74', 12, 'purchase_order/po_complete'),
(194, 1, '2017-06-19 08:01:02', 0, 'PO Receiving', 'PO 0031', '75', -1, 'purchase_order/po_complete'),
(195, 1, '2017-06-19 08:21:35', 0, 'New Product', 'PN00031', '15', 0, 'items/save'),
(196, 1, '2017-06-19 08:21:35', 6, 'Manual Edit of Quantity', '6', '15', 0, 'items/save'),
(197, 1, '2017-06-19 08:21:35', 8, 'Manual Edit of Quantity', '0', '15', 0, 'items/save'),
(198, 1, '2017-06-19 08:21:35', 5, 'Manual Edit of Quantity', '0', '15', 0, 'items/save'),
(199, 1, '2017-06-19 08:21:36', 4, 'Manual Edit of Quantity', '0', '15', 0, 'items/save'),
(200, 1, '2017-06-19 08:21:36', 2, 'Manual Edit of Quantity', '9', '15', 0, 'items/save'),
(201, 1, '2017-06-19 08:21:36', 3, 'Manual Edit of Quantity', '0', '15', 0, 'items/save'),
(202, 1, '2017-06-19 08:23:18', 0, 'Update Product', 'PN00031', '15', 0, 'items/save/15'),
(203, 1, '2017-06-19 08:25:05', 0, 'PO Receiving', 'PO 0032', '76', 12, 'purchase_order/po_complete'),
(204, 1, '2017-06-19 09:00:18', 0, 'GRN Receiving', 'GRN 0027', '77', 12, 'grn/complete'),
(205, 1, '2017-06-19 09:03:47', 0, 'GRN Receiving', 'GRN 0028', '78', 12, 'grn/complete'),
(206, 1, '2017-06-19 12:34:28', 0, 'GRN Receiving', 'GRN 0029', '79', 12, 'grn/complete'),
(207, 1, '2017-06-19 14:09:39', 0, 'PO Receiving', 'PO 0033', '80', 12, 'purchase_order/po_complete'),
(208, 1, '2017-06-19 14:10:13', 0, 'GRN Receiving', 'GRN 0030', '81', 12, 'grn/complete'),
(209, 1, '2017-06-19 14:18:37', 0, 'New Product', 'Prnum 001662017', '16', 0, 'items/save'),
(210, 1, '2017-06-19 14:18:37', 6, 'Manual Edit of Quantity', '0', '16', 0, 'items/save'),
(211, 1, '2017-06-19 14:18:38', 8, 'Manual Edit of Quantity', '0', '16', 0, 'items/save'),
(212, 1, '2017-06-19 14:18:38', 5, 'Manual Edit of Quantity', '0', '16', 0, 'items/save'),
(213, 1, '2017-06-19 14:18:38', 4, 'Manual Edit of Quantity', '0', '16', 0, 'items/save'),
(214, 1, '2017-06-19 14:18:39', 2, 'Manual Edit of Quantity', '0', '16', 0, 'items/save'),
(215, 1, '2017-06-19 14:18:39', 3, 'Manual Edit of Quantity', '0', '16', 0, 'items/save'),
(216, 1, '2017-06-19 14:19:44', 0, 'Update Product', 'Prnum 001662017', '16', 0, 'items/save/16'),
(217, 1, '2017-06-19 14:19:44', 6, 'Manual Edit of Quantity', '6', '16', 0, 'items/save/16'),
(218, 1, '2017-06-19 14:19:45', 2, 'Manual Edit of Quantity', '7', '16', 0, 'items/save/16'),
(219, 1, '2017-06-19 14:26:45', 0, 'PO Receiving', 'PO 0034', '82', 13, 'purchase_order/po_complete'),
(220, 1, '2017-06-19 14:28:22', 0, 'GRN Receiving', 'GRN 0031', '83', 13, 'grn/complete'),
(221, 1, '2017-06-19 14:29:52', 0, 'GRN Receiving', 'GRN 0032', '84', 13, 'grn/complete'),
(222, 1, '2017-06-20 06:41:23', 0, 'PO Receiving', 'PO 0035', '85', 15, 'purchase_order/po_complete'),
(223, 1, '2017-06-20 06:44:35', 0, 'Update Employee', '55', '55', 0, 'employees/save/55'),
(224, 1, '2017-06-20 06:46:15', 0, 'Update Employee', '10', '10', 0, 'employees/save/10'),
(225, 1, '2017-06-20 06:46:30', 0, 'Update Employee', '55', '55', 0, 'employees/save/55'),
(226, 1, '2017-06-20 06:46:41', 0, 'Update Employee', '10', '10', 0, 'employees/save/10'),
(227, 1, '2017-06-20 12:07:47', 0, 'GRN Receiving', 'GRN 0033', '86', 12, 'grn/complete'),
(228, 1, '2017-06-20 12:14:30', 0, 'PO Receiving', 'PO 0036', '87', 11, 'purchase_order/po_complete'),
(229, 1, '2017-06-20 12:15:09', 0, 'GRN Receiving', 'GRN 0034', '88', 11, 'grn/complete'),
(230, 1, '2017-06-20 15:14:29', 0, 'Supply stock', 'REQ 0006', '89', 2, 'requisition/complete'),
(231, 1, '2017-06-21 06:24:09', 0, 'New Product', 'ISBN 01234', '17', 0, 'items/save'),
(232, 1, '2017-06-21 06:24:09', 6, 'Manual Edit of Quantity', '0', '17', 0, 'items/save'),
(233, 1, '2017-06-21 06:24:10', 8, 'Manual Edit of Quantity', '0', '17', 0, 'items/save'),
(234, 1, '2017-06-21 06:24:10', 5, 'Manual Edit of Quantity', '0', '17', 0, 'items/save'),
(235, 1, '2017-06-21 06:24:11', 4, 'Manual Edit of Quantity', '0', '17', 0, 'items/save'),
(236, 1, '2017-06-21 06:24:11', 2, 'Manual Edit of Quantity', '0', '17', 0, 'items/save'),
(237, 1, '2017-06-21 06:24:11', 3, 'Manual Edit of Quantity', '0', '17', 0, 'items/save'),
(238, 1, '2017-06-21 06:27:35', 0, 'Update Product', 'ISBN 01234', '17', 0, 'items/save/17'),
(239, 1, '2017-06-21 06:27:35', 6, 'Manual Edit of Quantity', '10', '17', 0, 'items/save/17'),
(240, 1, '2017-06-21 06:27:36', 2, 'Manual Edit of Quantity', '12', '17', 0, 'items/save/17'),
(241, 1, '2017-06-21 06:28:15', 0, 'Update Product', 'ISBN 01234', '17', 0, 'items/save/17'),
(242, 1, '2017-06-21 06:42:40', 0, 'Stock Order Sent', 'SO 0012', '90', 3, 'stock_order/complete'),
(243, 1, '2017-06-21 06:43:42', 0, 'Update Product', 'ISBN 01234', '17', 0, 'items/save/17'),
(244, 1, '2017-06-21 06:43:42', 0, 'Update Product', 'ISBN 01234', '17', 0, 'items/save/17'),
(245, 1, '2017-06-21 06:45:36', 0, 'Supply stock', 'REQ 0007', '91', 3, 'requisition/complete'),
(246, 1, '2017-06-21 06:47:32', 0, 'SOC Receiving', 'SOC 0003', '92', 3, 'stockorder_check/complete'),
(247, 1, '2017-06-21 06:49:58', 0, 'Stock Order Sent', 'SO 0013', '93', 2, 'stock_order/complete'),
(248, 1, '2017-06-21 06:50:25', 0, 'Supply stock', 'REQ 0008', '94', 2, 'requisition/complete'),
(249, 1, '2017-06-21 06:50:41', 0, 'SOC Receiving', 'SOC 0004', '95', 2, 'stockorder_check/complete'),
(250, 1, '2017-06-21 06:53:29', 0, 'Update Product', 'ISBN 01234', '17', 0, 'items/save/17'),
(251, 1, '2017-06-21 06:53:30', 3, 'Manual Edit of Quantity', '3', '17', 0, 'items/save/17'),
(252, 1, '2017-06-21 07:12:17', 0, 'New Product', 'sample', '18', 0, 'items/save'),
(253, 1, '2017-06-21 07:12:17', 6, 'Manual Edit of Quantity', '12', '18', 0, 'items/save'),
(254, 1, '2017-06-21 07:12:17', 8, 'Manual Edit of Quantity', '0', '18', 0, 'items/save'),
(255, 1, '2017-06-21 07:12:17', 5, 'Manual Edit of Quantity', '0', '18', 0, 'items/save'),
(256, 1, '2017-06-21 07:12:17', 4, 'Manual Edit of Quantity', '0', '18', 0, 'items/save'),
(257, 1, '2017-06-21 07:12:18', 2, 'Manual Edit of Quantity', '6', '18', 0, 'items/save'),
(258, 1, '2017-06-21 07:12:18', 3, 'Manual Edit of Quantity', '0', '18', 0, 'items/save'),
(259, 1, '2017-06-21 07:13:08', 0, 'Stock Order Sent', 'SO 0014', '96', 2, 'stock_order/complete'),
(260, 1, '2017-06-21 07:13:24', 0, 'Supply stock', 'REQ 0009', '97', 2, 'requisition/complete'),
(261, 1, '2017-06-21 07:14:32', 0, 'SOC Receiving', 'SOC 0005', '98', 2, 'stockorder_check/complete'),
(262, 1, '2017-06-21 07:16:41', 0, 'Update Product', 'sample', '18', 0, 'items/save/18'),
(263, 1, '2017-06-21 07:16:41', 6, 'Manual Edit of Quantity', '2', '18', 0, 'items/save/18'),
(264, 1, '2017-06-21 07:16:41', 2, 'Manual Edit of Quantity', '9', '18', 0, 'items/save/18'),
(265, 1, '2017-06-21 07:16:42', 0, 'Update Product', 'sample', '18', 0, 'items/save/18'),
(266, 1, '2017-06-21 07:17:25', 0, 'Stock Order Sent', 'SO 0015', '99', 2, 'stock_order/complete'),
(267, 1, '2017-06-21 07:18:02', 0, 'Supply stock', 'REQ 0010', '100', 2, 'requisition/complete'),
(268, 1, '2017-06-21 07:18:41', 0, 'SOC Receiving', 'SOC 0006', '101', 2, 'stockorder_check/complete'),
(269, 1, '2017-06-21 07:24:10', 0, 'Update Product', 'sample', '18', 0, 'items/save/18'),
(270, 1, '2017-06-21 07:58:19', 0, 'Stock Order Sent', 'SO 0016', '102', 2, 'stock_order/complete'),
(271, 1, '2017-06-21 07:58:30', 0, 'Stock Order Sent', 'SO 0017', '103', 2, 'stock_order/complete'),
(272, 1, '2017-06-21 07:59:00', 0, 'Supply stock', 'REQ 0011', '104', 2, 'requisition/complete'),
(273, 1, '2017-06-21 07:59:32', 0, 'SOC Receiving', 'SOC 0007', '105', 2, 'stockorder_check/complete'),
(274, 1, '2017-06-21 08:12:55', 0, 'Stock Order Sent', 'SO 0018', '106', 2, 'stock_order/complete'),
(275, 1, '2017-06-21 08:13:30', 0, 'PO Receiving', 'PO 0037', '107', 12, 'purchase_order/po_complete'),
(276, 1, '2017-06-21 08:14:27', 0, 'GRN Receiving', 'GRN 0035', '108', 12, 'grn/complete'),
(277, 1, '2017-06-21 08:18:11', 0, 'Stock Order Sent', 'SO 0019', '109', 2, 'stock_order/complete'),
(278, 1, '2017-06-21 08:18:50', 0, 'Update Product', 'PO 00034', '13', 0, 'items/save/13'),
(279, 1, '2017-06-21 08:18:51', 5, 'Manual Edit of Quantity', '10', '13', 0, 'items/save/13'),
(280, 1, '2017-06-21 08:18:51', 0, 'Update Product', 'PO 00034', '13', 0, 'items/save/13'),
(281, 1, '2017-06-21 08:18:52', 0, 'Update Product', 'PO 00034', '13', 0, 'items/save/13'),
(282, 1, '2017-06-21 08:19:09', 0, 'Stock Order Sent', 'SO 0020', '110', 2, 'stock_order/complete'),
(283, 1, '2017-06-21 08:20:23', 0, 'Supply stock', 'REQ 0012', '111', 2, 'requisition/complete'),
(284, 1, '2017-06-21 08:20:59', 0, 'SOC Receiving', 'SOC 0008', '112', 2, 'stockorder_check/complete'),
(285, 1, '2017-06-21 08:32:59', 0, 'New Product', 'UPC00124', '19', 0, 'items/save'),
(286, 1, '2017-06-21 08:32:59', 6, 'Manual Edit of Quantity', '0', '19', 0, 'items/save'),
(287, 1, '2017-06-21 08:32:59', 8, 'Manual Edit of Quantity', '0', '19', 0, 'items/save'),
(288, 1, '2017-06-21 08:32:59', 5, 'Manual Edit of Quantity', '0', '19', 0, 'items/save'),
(289, 1, '2017-06-21 08:33:00', 4, 'Manual Edit of Quantity', '0', '19', 0, 'items/save'),
(290, 1, '2017-06-21 08:33:00', 2, 'Manual Edit of Quantity', '0', '19', 0, 'items/save'),
(291, 1, '2017-06-21 08:33:00', 3, 'Manual Edit of Quantity', '0', '19', 0, 'items/save'),
(292, 1, '2017-06-21 08:49:54', 0, 'Update Product', 'UPC00124', '19', 0, 'items/save/19'),
(293, 1, '2017-06-21 08:49:54', 6, 'Manual Edit of Quantity', '9', '19', 0, 'items/save/19'),
(294, 1, '2017-06-21 08:49:55', 5, 'Manual Edit of Quantity', '9', '19', 0, 'items/save/19'),
(295, 1, '2017-06-21 08:49:55', 3, 'Manual Edit of Quantity', '10', '19', 0, 'items/save/19'),
(296, 1, '2017-06-21 08:50:28', 0, 'Update Product', 'UPC00124', '19', 0, 'items/save/19'),
(297, 1, '2017-06-22 06:11:59', 0, 'New Product', 'Product123', '20', 0, 'items/save'),
(298, 1, '2017-06-22 06:12:00', 6, 'Manual Edit of Quantity', '4', '20', 0, 'items/save'),
(299, 1, '2017-06-22 06:12:00', 8, 'Manual Edit of Quantity', '0', '20', 0, 'items/save'),
(300, 1, '2017-06-22 06:12:00', 5, 'Manual Edit of Quantity', '4', '20', 0, 'items/save'),
(301, 1, '2017-06-22 06:12:00', 4, 'Manual Edit of Quantity', '0', '20', 0, 'items/save'),
(302, 1, '2017-06-22 06:12:00', 2, 'Manual Edit of Quantity', '5', '20', 0, 'items/save'),
(303, 1, '2017-06-22 06:12:01', 3, 'Manual Edit of Quantity', '0', '20', 0, 'items/save'),
(304, 1, '2017-06-22 06:48:22', 0, 'Update Product', 'UPC00124', '19', 0, 'items/save/19'),
(305, 1, '2017-06-23 08:25:36', 0, 'Update Employee', '10', '10', 0, 'employees/save/10'),
(306, 1, '2017-06-23 08:27:23', 0, 'Update Employee', '8', '8', 0, 'employees/save/8'),
(307, 1, '2017-06-23 08:29:57', 0, 'Update Employee', '8', '8', 0, 'employees/save/8'),
(308, 10, '2017-06-23 08:47:36', 0, 'Stock Order Sent', 'SO 0021', '113', 2, 'stock_order/complete'),
(309, 1, '2017-06-23 09:01:31', 0, 'Stock Order Sent', 'SO 0022', '114', 3, 'stock_order/complete'),
(310, 1, '2017-06-23 09:29:09', 0, 'Update Employee', '8', '8', 0, 'employees/save/8'),
(311, 10, '2017-06-23 09:30:33', 0, 'Stock Order Sent', 'SO 0023', '115', 2, 'stock_order/complete'),
(312, 1, '2017-06-23 11:46:32', 0, 'Stock Order Sent', 'SO 0024', '116', 3, 'stock_order/complete'),
(313, 1, '2017-06-23 12:17:34', 0, 'Stock Order Sent', 'SO 0025', '117', 3, 'stock_order/complete'),
(314, 1, '2017-06-23 12:59:58', 0, 'Supply stock', 'REQ 0013', '118', 3, 'requisition/complete'),
(315, 1, '2017-06-23 13:01:11', 0, 'Supply stock', 'REQ 0014', '119', 2, 'requisition/complete'),
(316, 1, '2017-06-23 13:17:29', 0, 'Stock Order Sent', 'SO 0026', '120', 2, 'stock_order/complete'),
(317, 1, '2017-06-23 13:18:10', 0, 'Supply stock', 'REQ 0015', '121', 2, 'requisition/complete'),
(318, 1, '2017-06-23 13:19:01', 0, 'SOC Receiving', 'SOC 0009', '122', 2, 'stockorder_check/complete'),
(319, 1, '2017-06-23 14:21:47', 0, 'Stock Order Sent', 'SO 0027', '123', 3, 'stock_order/complete'),
(320, 1, '2017-06-23 14:55:47', 0, 'Update Employee', '7', '7', 0, 'employees/save/7'),
(321, 1, '2017-06-23 15:29:14', 0, 'Supply stock', 'REQ 0016', '124', 2, 'requisition/complete'),
(322, 1, '2017-06-24 06:21:29', 0, 'Supply stock', 'REQ 0017', '125', 2, 'requisition/complete'),
(323, 1, '2017-06-24 06:30:26', 0, 'Supply stock', 'REQ 0018', '126', 2, 'requisition/complete'),
(324, 1, '2017-06-24 06:31:22', 0, 'SOC Receiving', 'SOC 0010', '127', 2, 'stockorder_check/complete'),
(325, 1, '2017-06-24 06:33:03', 0, 'Supply stock', 'REQ 0019', '128', 2, 'requisition/complete'),
(326, 1, '2017-06-24 06:33:36', 0, 'SOC Receiving', 'SOC 0011', '129', 2, 'stockorder_check/complete'),
(327, 1, '2017-06-24 06:36:48', 0, 'Stock Order Sent', 'SO 0028', '130', 3, 'stock_order/complete'),
(328, 1, '2017-06-24 06:41:57', 0, 'Supply stock', 'REQ 0020', '131', 3, 'requisition/complete'),
(329, 1, '2017-06-24 09:03:48', 0, 'SOC Receiving', 'SOC 0012', '132', 3, 'stockorder_check/complete'),
(330, 1, '2017-06-27 07:30:47', 0, 'Update Employee', '8', '8', 0, 'employees/save/8'),
(331, 1, '2017-06-29 07:32:41', 0, 'Update Employee', '55', '55', 0, 'employees/save/55');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_contactus`
--

CREATE TABLE `ospos_contactus` (
  `id` bigint(20) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `fullname` varchar(200) COLLATE utf8_bin NOT NULL,
  `email` varchar(200) COLLATE utf8_bin NOT NULL,
  `phone` varchar(20) COLLATE utf8_bin NOT NULL,
  `subject` text COLLATE utf8_bin NOT NULL,
  `message` text COLLATE utf8_bin NOT NULL,
  `cdate` int(15) NOT NULL,
  `ip_address` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ospos_contactus`
--

INSERT INTO `ospos_contactus` (`id`, `employee_id`, `fullname`, `email`, `phone`, `subject`, `message`, `cdate`, `ip_address`) VALUES
(1, 1, '5675767', '567567@fyj.rtfy', '5676456645', '567456456456456', '567456456456456', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_currency`
--

CREATE TABLE `ospos_currency` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(10) CHARACTER SET utf8 NOT NULL,
  `code` varchar(10) NOT NULL,
  `base_currency` int(1) NOT NULL DEFAULT '0',
  `rate` float(15,10) NOT NULL DEFAULT '0.0000000000',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_currency`
--

INSERT INTO `ospos_currency` (`id`, `name`, `symbol`, `code`, `base_currency`, `rate`, `status`) VALUES
(1, 'Lao kip', '₭', 'LAK', 1, 1.0000000000, 1),
(2, 'US Dollar', '$', 'USD', 0, 0.5600000024, 1),
(3, 'Euro', '€', 'EUR', 0, 0.0001100000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_currency_rate`
--

CREATE TABLE `ospos_currency_rate` (
  `id` int(255) NOT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `rate` float(15,10) NOT NULL DEFAULT '0.0000000000',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_currency_rate`
--

INSERT INTO `ospos_currency_rate` (`id`, `currency_id`, `employee_id`, `rate`, `date`, `note`) VALUES
(1, 1, 1, 1.0000000000, '2017-06-01 17:37:16', 'base'),
(2, 2, 1, 0.0001200000, '2017-06-01 17:39:17', NULL),
(3, 2, 1, 54.0000000000, '2017-06-02 10:10:42', NULL),
(4, 2, 1, 23.0000000000, '2017-06-02 03:15:09', NULL),
(5, 3, 1, 10.0000000000, '2017-05-30 12:20:33', 'initial'),
(6, 3, 1, 43.0000000000, '2017-05-31 13:50:42', NULL),
(7, 3, 1, 30.0000000000, '2017-06-04 19:26:38', NULL),
(8, 2, 1, 0.0001200000, '2017-06-03 19:27:26', NULL),
(9, 3, 1, 0.0001100000, '2017-06-01 19:27:41', NULL),
(10, 2, 1, 67.0000000000, '2017-06-05 00:00:00', NULL),
(11, 2, 1, 0.0001200000, '2017-06-04 17:41:06', NULL),
(12, 2, 1, 0.5600000024, '2017-06-06 14:29:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_customers`
--

CREATE TABLE `ospos_customers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `taxable` int(1) NOT NULL DEFAULT '1',
  `sales_tax_code` varchar(32) NOT NULL DEFAULT '1',
  `discount_percent` decimal(15,2) NOT NULL DEFAULT '0.00',
  `package_id` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_customers`
--

INSERT INTO `ospos_customers` (`person_id`, `company_name`, `account_number`, `taxable`, `sales_tax_code`, `discount_percent`, `package_id`, `points`, `deleted`) VALUES
(2, 'National Products', '5467475575', 1, '', '4.00', NULL, NULL, 0),
(3, 'Panda Express', '685674454', 1, '', '6.00', NULL, NULL, 0),
(4, 'Gastro Events', '7553535353', 1, '', '2.00', NULL, NULL, 0),
(5, 'Marketing Hub', '5785445444', 1, '', '2.50', NULL, NULL, 0),
(6, 'Epson Robots Computer', '67474747474', 1, '', '3.00', NULL, NULL, 0),
(16, NULL, NULL, 1, '', '0.00', NULL, NULL, 1),
(17, NULL, NULL, 1, '', '0.00', NULL, NULL, 1),
(19, NULL, NULL, 1, '', '0.00', NULL, NULL, 1),
(20, 'Ancy info', '20406075', 1, '', '10.00', NULL, NULL, 1),
(21, NULL, NULL, 1, '', '0.00', NULL, NULL, 1),
(22, NULL, NULL, 1, '', '0.00', NULL, NULL, 1),
(23, NULL, NULL, 1, '', '0.00', NULL, NULL, 1),
(24, NULL, NULL, 1, '', '0.00', NULL, NULL, 1),
(25, NULL, NULL, 1, '', '0.00', NULL, NULL, 1),
(26, 'Ancy info', '34324324', 1, '', '12.00', NULL, NULL, 0),
(27, '##0_);_(* \\(#', '##0\\);_(* "-"_);_(@_)y', 1, '1', '0.00', NULL, NULL, 1),
(28, ' east to remove and dispose debris', ' 24 Volt deep  cycle battery for maximum run time Service and parking brakes', 0, '1', '0.00', NULL, NULL, 1),
(29, '', NULL, 1, '1', '5.00', NULL, NULL, 0),
(30, '', NULL, 1, '1', '5.00', NULL, NULL, 1),
(31, '', NULL, 1, '1', '5.00', NULL, NULL, 1),
(32, '', NULL, 1, '1', '5.00', NULL, NULL, 0),
(33, NULL, NULL, 1, '', '5.00', NULL, NULL, 1),
(34, 'Ancy info', NULL, 1, '', '0.00', NULL, NULL, 1),
(35, 'Ancy info', NULL, 1, '', '0.00', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_customers_packages`
--

CREATE TABLE `ospos_customers_packages` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `points_percent` float NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_customers_points`
--

CREATE TABLE `ospos_customers_points` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `points_earned` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_dinner_tables`
--

CREATE TABLE `ospos_dinner_tables` (
  `dinner_table_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_dinner_tables`
--

INSERT INTO `ospos_dinner_tables` (`dinner_table_id`, `name`, `status`, `deleted`) VALUES
(1, 'Delivery', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_employees`
--

CREATE TABLE `ospos_employees` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `employees_login` enum('headoffice','warehouse','store') NOT NULL DEFAULT 'store',
  `account_id` int(11) NOT NULL,
  `hash_version` int(1) NOT NULL DEFAULT '2',
  `language_code` varchar(20) NOT NULL DEFAULT 'en',
  `role_id` int(11) NOT NULL,
  `forgotpassword` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_employees`
--

INSERT INTO `ospos_employees` (`username`, `password`, `person_id`, `deleted`, `employees_login`, `account_id`, `hash_version`, `language_code`, `role_id`, `forgotpassword`) VALUES
('admin', '$2y$10$E0cpeLO9RT2k6bAziXJ29u3/w8pNItolzNN1/Az5B.b/UlTcs.XfW', 1, 0, 'headoffice', 64, 2, 'en', 2, ''),
('jamesbyun', '$2y$10$EXzkrz30DVVlFGLS3wvl1ONuxcM3faqy6CQhPVEBJ5/Ehgnw4eOCy', 7, 0, 'warehouse', 88, 2, 'en', 0, ''),
('jenifer', '$2y$10$GYAcIqMihD/5fXJPEIkmDepeAqUhox9GWFQwhFVXywbsK6ubKWzDi', 8, 0, '', 65, 2, 'en', 3, ''),
('lawarance', '$2y$10$kIjFpThpGSLzOT/REqBO/O4sV7Re2SgMR6UtmyW04nDDdBD3p9dvm', 10, 0, 'store', 87, 2, 'en', 4, ''),
('susan', '$2y$10$XbCYwtTnIxO0N1S9hECm8ebvXJTjXKOQXms7WeimaaDZvWp0k5CO2', 9, 0, 'store', 0, 2, 'en', 0, ''),
('test12345678', '$2y$10$.WW3W6ROvUzTFK73isUjH.Ot0ApVFUouGFdF9FA5eCQIVWWKD9Zg.', 55, 0, 'headoffice', 86, 2, 'en', 2, 'd2f65fd1f17602bd57bcac1c07075bc9');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_employees_role`
--

CREATE TABLE `ospos_employees_role` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `login_type` enum('headoffice','warehouse','store') NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_employees_role`
--

INSERT INTO `ospos_employees_role` (`id`, `name`, `login_type`, `deleted`) VALUES
(1, '', '', 0),
(2, 'Head Office Admin', 'headoffice', 0),
(3, 'SUPERVISOR', 'warehouse', 0),
(4, 'Sales staff', 'store', 0),
(5, 'Sales Officer', 'store', 0),
(6, 'Accountant', 'headoffice', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_expenses`
--

CREATE TABLE `ospos_expenses` (
  `id` int(11) NOT NULL,
  `expense_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_account` int(11) DEFAULT NULL,
  `to_account` int(11) DEFAULT NULL,
  `amount` decimal(15,3) NOT NULL,
  `tax_id` varchar(255) DEFAULT NULL,
  `tax_amount` float(15,3) NOT NULL,
  `tax_available` tinyint(1) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `reference` varchar(200) DEFAULT NULL,
  `note` text,
  `status` enum('paid','unpaid') NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_expenses`
--

INSERT INTO `ospos_expenses` (`id`, `expense_date`, `from_account`, `to_account`, `amount`, `tax_id`, `tax_amount`, `tax_available`, `supplier_id`, `reference`, `note`, `status`) VALUES
(1, '2017-06-01 00:00:00', 41, 54, '4343.000', 'Laos at a standard rate', 10.000, 1, 14, '45456', '456456', 'unpaid'),
(2, '2017-06-01 00:00:00', 58, 54, '56567.000', 'Laos at a standard rate', 10.000, 0, 13, '56756', '7567567', 'unpaid'),
(3, '2017-06-01 00:00:00', 55, 10, '567567567.000', 'Laos at a standard rate', 10.000, 1, 13, '45354', '345345', 'unpaid'),
(4, '2017-06-01 00:00:00', 55, 10, '456456.000', 'Laos at a standard rate', 10.000, 1, 13, '456456', '', 'unpaid'),
(5, '2017-06-05 00:00:00', 60, 53, '5.000', 'Laos at a standard rate', 10.000, 1, 11, '56', '567', 'unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_giftcards`
--

CREATE TABLE `ospos_giftcards` (
  `record_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `giftcard_id` int(11) NOT NULL,
  `giftcard_number` varchar(255) DEFAULT NULL,
  `value` decimal(15,2) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `person_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_giftcards`
--

INSERT INTO `ospos_giftcards` (`record_time`, `giftcard_id`, `giftcard_number`, `value`, `deleted`, `person_id`) VALUES
('2017-06-26 07:30:41', 1, '567567', '200.00', 0, NULL),
('2017-06-24 13:32:40', 2, '148039-0DE00', '0.00', 1, NULL),
('2017-06-24 13:34:33', 3, '111194-0DE00', '0.00', 1, NULL),
('2017-06-24 13:40:46', 4, '3FEBCF-15044458787', '15044458787.00', 0, NULL),
('2017-06-24 13:43:24', 5, '123123', '100.00', 0, 26);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_grants`
--

CREATE TABLE `ospos_grants` (
  `permission_id` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_grants`
--

INSERT INTO `ospos_grants` (`permission_id`, `person_id`) VALUES
('accounts', 1),
('auditingtrail', 1),
('config', 1),
('customers', 1),
('employees', 1),
('giftcards', 1),
('grn', 1),
('grn_Warehouse ', 1),
('grn_Warehouse2', 1),
('inventories', 1),
('inventories_Alwa Store', 1),
('inventories_Anand Store', 1),
('inventories_Nellai Store', 1),
('inventories_Sivaksi Store', 1),
('inventories_Warehouse ', 1),
('inventories_Warehouse2', 1),
('invoice', 1),
('invoice_Alwa Store', 1),
('invoice_Anand Store', 1),
('invoice_Nellai Store', 1),
('invoice_Sivaksi Store', 1),
('items', 1),
('items_Alwa Store', 1),
('items_Anand Store', 1),
('items_Nellai Store', 1),
('items_Sivaksi Store', 1),
('items_Warehouse ', 1),
('items_Warehouse2', 1),
('messages', 1),
('pay', 1),
('pay_Warehouse ', 1),
('pay_Warehouse2', 1),
('purchase_order', 1),
('purchase_order_Warehouse ', 1),
('purchase_order_Warehouse2', 1),
('reports', 1),
('reports_categories', 1),
('reports_customers', 1),
('reports_discounts', 1),
('reports_employees', 1),
('reports_inventory', 1),
('reports_items', 1),
('reports_payments', 1),
('reports_receivings', 1),
('reports_sales', 1),
('reports_suppliers', 1),
('reports_taxes', 1),
('requisition', 1),
('requisition_Warehouse ', 1),
('requisition_Warehouse2', 1),
('return', 1),
('return_Alwa Store', 1),
('return_Anand Store', 1),
('return_Nellai Store', 1),
('return_Sivaksi Store', 1),
('return_Warehouse ', 1),
('return_Warehouse2', 1),
('sales', 1),
('sales_Alwa Store', 1),
('sales_Anand Store', 1),
('sales_Nellai Store', 1),
('sales_Sivaksi Store', 1),
('stockorder_check', 1),
('stockorder_check_Alwa Store', 1),
('stockorder_check_Anand Store', 1),
('stockorder_check_Nellai Store', 1),
('stockorder_check_Sivaksi Store', 1),
('stock_order', 1),
('stock_order_Alwa Store', 1),
('stock_order_Anand Store', 1),
('stock_order_Nellai Store', 1),
('stock_order_Sivaksi Store', 1),
('suppliers', 1),
('taxes', 1),
('accounts', 2),
('auditingtrail', 2),
('config', 2),
('customers', 2),
('employees', 2),
('giftcards', 2),
('grn', 2),
('grn_Warehouse ', 2),
('grn_Warehouse2', 2),
('inventories', 2),
('inventories_Alwa Store', 2),
('inventories_Anand Store', 2),
('inventories_Nellai Store', 2),
('inventories_Sivaksi Store', 2),
('inventories_Warehouse ', 2),
('inventories_Warehouse2', 2),
('invoice', 2),
('invoice_Alwa Store', 2),
('invoice_Anand Store', 2),
('invoice_Nellai Store', 2),
('invoice_Sivaksi Store', 2),
('items', 2),
('items_Alwa Store', 2),
('items_Anand Store', 2),
('items_Nellai Store', 2),
('items_Sivaksi Store', 2),
('items_Warehouse ', 2),
('items_Warehouse2', 2),
('messages', 2),
('pay', 2),
('pay_Warehouse ', 2),
('pay_Warehouse2', 2),
('purchase_order', 2),
('purchase_order_Warehouse ', 2),
('purchase_order_Warehouse2', 2),
('reports', 2),
('reports_categories', 2),
('reports_customers', 2),
('reports_discounts', 2),
('reports_employees', 2),
('reports_inventory', 2),
('reports_items', 2),
('reports_payments', 2),
('reports_receivings', 2),
('reports_sales', 2),
('reports_suppliers', 2),
('reports_taxes', 2),
('requisition', 2),
('requisition_Warehouse ', 2),
('requisition_Warehouse2', 2),
('return', 2),
('return_Alwa Store', 2),
('return_Anand Store', 2),
('return_Nellai Store', 2),
('return_Sivaksi Store', 2),
('return_Warehouse ', 2),
('return_Warehouse2', 2),
('sales', 2),
('sales_Alwa Store', 2),
('sales_Anand Store', 2),
('sales_Nellai Store', 2),
('sales_Sivaksi Store', 2),
('stockorder_check', 2),
('stockorder_check_Alwa Store', 2),
('stockorder_check_Anand Store', 2),
('stockorder_check_Nellai Store', 2),
('stockorder_check_Sivaksi Store', 2),
('stock_order', 2),
('stock_order_Alwa Store', 2),
('stock_order_Anand Store', 2),
('stock_order_Nellai Store', 2),
('stock_order_Sivaksi Store', 2),
('suppliers', 2),
('taxes', 2),
('accounts', 3),
('auditingtrail', 3),
('config', 3),
('customers', 3),
('employees', 3),
('giftcards', 3),
('grn', 3),
('grn_Warehouse ', 3),
('grn_Warehouse2', 3),
('inventories', 3),
('inventories_Alwa Store', 3),
('inventories_Nellai Store', 3),
('inventories_Warehouse ', 3),
('inventories_Warehouse2', 3),
('invoice', 3),
('invoice_Alwa Store', 3),
('invoice_Anand Store', 3),
('invoice_Nellai Store', 3),
('items', 3),
('items_Alwa Store', 3),
('items_Anand Store', 3),
('items_Nellai Store', 3),
('messages', 3),
('pay', 3),
('pay_Warehouse ', 3),
('pay_Warehouse2', 3),
('purchase_order', 3),
('purchase_order_Warehouse ', 3),
('purchase_order_Warehouse2', 3),
('reports', 3),
('reports_categories', 3),
('reports_customers', 3),
('reports_discounts', 3),
('reports_employees', 3),
('reports_inventory', 3),
('reports_items', 3),
('reports_payments', 3),
('reports_receivings', 3),
('reports_sales', 3),
('reports_suppliers', 3),
('reports_taxes', 3),
('requisition', 3),
('requisition_Warehouse ', 3),
('return', 3),
('return_Alwa Store', 3),
('return_Nellai Store', 3),
('return_Warehouse ', 3),
('return_Warehouse2', 3),
('sales', 3),
('sales_Alwa Store', 3),
('sales_Nellai Store', 3),
('stockorder_check', 3),
('stockorder_check_Alwa Store', 3),
('stockorder_check_Anand Store', 3),
('stockorder_check_Nellai Store', 3),
('stock_order', 3),
('stock_order_Alwa Store', 3),
('stock_order_Nellai Store', 3),
('suppliers', 3),
('taxes', 3),
('customers', 4),
('reports', 4),
('reports_customers', 4),
('reports_discounts', 4),
('reports_sales', 4),
('requisition', 4),
('requisition_Warehouse ', 4),
('return', 4),
('return_Alwa Store', 4),
('sales', 4),
('sales_Alwa Store', 4),
('stockorder_check', 4),
('stockorder_check_Alwa Store', 4),
('stock_order', 4),
('stock_order_Alwa Store', 4),
('grn', 5),
('grn_Warehouse ', 5),
('accounts', 6);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_income`
--

CREATE TABLE `ospos_income` (
  `id` int(11) NOT NULL,
  `income_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_account` int(11) DEFAULT NULL,
  `to_account` int(11) DEFAULT NULL,
  `amount` decimal(15,3) NOT NULL,
  `tax_id` varchar(255) DEFAULT NULL,
  `tax_amount` float(15,3) NOT NULL,
  `tax_available` tinyint(1) DEFAULT NULL,
  `people_id` int(11) DEFAULT NULL,
  `reference` varchar(200) DEFAULT NULL,
  `note` text,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_income`
--

INSERT INTO `ospos_income` (`id`, `income_date`, `from_account`, `to_account`, `amount`, `tax_id`, `tax_amount`, `tax_available`, `people_id`, `reference`, `note`, `status`) VALUES
(1, '2017-06-06 00:00:00', 24, 54, '567567.000', 'Laos at a standard rate', 10.000, 0, 14, '567', '', 0),
(2, '2017-06-05 00:00:00', 24, 14, '567567.000', 'Laos at a standard rate', 10.000, 0, 11, '567', '567', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_inventory`
--

CREATE TABLE `ospos_inventory` (
  `trans_id` int(11) NOT NULL,
  `trans_items` int(11) NOT NULL DEFAULT '0',
  `trans_user` int(11) NOT NULL DEFAULT '0',
  `trans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_comment` text NOT NULL,
  `trans_location` int(11) NOT NULL,
  `trans_inventory` decimal(15,3) NOT NULL DEFAULT '0.000',
  `price` decimal(15,3) NOT NULL,
  `balance` decimal(15,3) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `trans_type` enum('purchase','sale','damage') NOT NULL DEFAULT 'purchase',
  `adjustments` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_inventory`
--

INSERT INTO `ospos_inventory` (`trans_id`, `trans_items`, `trans_user`, `trans_date`, `trans_comment`, `trans_location`, `trans_inventory`, `price`, `balance`, `employee_id`, `trans_type`, `adjustments`) VALUES
(1, 6, 1, '2017-05-30 14:19:02', 'Manual Edit of Quantity', 6, '0.000', '10.000', '0.000', 1, 'damage', 0),
(2, 6, 1, '2017-05-30 14:19:03', 'Manual Edit of Quantity', 8, '0.000', '10.000', '0.000', 1, 'damage', 0),
(3, 6, 1, '2017-05-30 14:19:03', 'Manual Edit of Quantity', 5, '0.000', '10.000', '0.000', 1, 'damage', 0),
(4, 6, 1, '2017-05-30 14:19:04', 'Manual Edit of Quantity', 4, '0.000', '10.000', '0.000', 1, 'damage', 0),
(5, 6, 1, '2017-05-30 14:19:04', 'Manual Edit of Quantity', 2, '0.000', '10.000', '0.000', 1, 'damage', 0),
(6, 6, 1, '2017-05-30 14:19:04', 'Manual Edit of Quantity', 3, '0.000', '10.000', '0.000', 1, 'damage', 0),
(7, 1, 7, '2017-05-30 14:21:48', 'GRN 0001', 3, '89.000', '10.000', '89.000', 7, 'purchase', 0),
(8, 2, 7, '2017-05-30 14:21:48', 'GRN 0001', 3, '54.000', '11.000', '54.000', 7, 'purchase', 0),
(9, 4, 7, '2017-05-30 14:21:48', 'GRN 0001', 3, '67.000', '10.000', '67.000', 7, 'purchase', 0),
(10, 5, 7, '2017-05-30 14:21:48', 'GRN 0001', 3, '435.000', '10.000', '435.000', 7, 'purchase', 0),
(11, 6, 7, '2017-05-30 14:21:48', 'GRN 0001', 3, '21.000', '10.000', '21.000', 7, 'purchase', 0),
(12, 1, 7, '2017-05-30 14:25:48', 'GRN 0002', 3, '911.000', '10.000', '1000.000', 7, 'purchase', 0),
(13, 2, 7, '2017-05-30 14:25:48', 'GRN 0002', 3, '941.000', '11.000', '995.000', 7, 'purchase', 0),
(14, 4, 7, '2017-05-30 14:25:48', 'GRN 0002', 3, '931.000', '10.000', '998.000', 7, 'purchase', 0),
(15, 5, 7, '2017-05-30 14:25:48', 'GRN 0002', 3, '561.000', '10.000', '996.000', 7, 'purchase', 0),
(16, 6, 7, '2017-05-30 14:25:48', 'GRN 0002', 3, '971.000', '10.000', '992.000', 7, 'purchase', 0),
(17, 1, 7, '2017-05-30 14:26:03', 'GRN 0003', 3, '1.000', '10.000', '1001.000', 7, 'purchase', 0),
(18, 2, 7, '2017-05-30 14:26:03', 'GRN 0003', 3, '5.000', '11.000', '1000.000', 7, 'purchase', 0),
(19, 4, 7, '2017-05-30 14:26:03', 'GRN 0003', 3, '2.000', '10.000', '1000.000', 7, 'purchase', 0),
(20, 5, 7, '2017-05-30 14:26:03', 'GRN 0003', 3, '4.000', '10.000', '1000.000', 7, 'purchase', 0),
(21, 6, 7, '2017-05-30 14:26:03', 'GRN 0003', 3, '8.000', '10.000', '1000.000', 7, 'purchase', 0),
(22, 1, 7, '2017-05-30 14:32:00', 'REQ 0001', 3, '-10.000', '10.000', '991.000', 7, 'sale', 0),
(23, 2, 7, '2017-05-30 14:32:00', 'REQ 0001', 3, '-10.000', '10.000', '990.000', 7, 'sale', 0),
(24, 5, 7, '2017-05-30 14:32:00', 'REQ 0001', 3, '-10.000', '10.000', '990.000', 7, 'sale', 0),
(25, 1, 10, '2017-05-30 14:34:13', 'SOC 0001', 8, '10.000', '10.000', '10.000', 10, 'purchase', 0),
(26, 2, 10, '2017-05-30 14:34:13', 'SOC 0001', 8, '10.000', '10.000', '10.000', 10, 'purchase', 0),
(27, 5, 10, '2017-05-30 14:34:13', 'SOC 0001', 8, '10.000', '10.000', '10.000', 10, 'purchase', 0),
(28, 6, 7, '2017-05-30 14:36:29', 'REQ 0002', 3, '-100.000', '10.000', '900.000', 7, 'sale', 0),
(29, 6, 1, '2017-05-30 14:36:49', 'SOC 0002', 5, '100.000', '10.000', '100.000', 1, 'purchase', 0),
(30, 4, 7, '2017-05-30 14:49:24', 'GRN 0004', 3, '1000.000', '10.000', '2000.000', 7, 'purchase', 0),
(31, 1, 1, '2017-05-30 15:36:50', 'SOK 5', 6, '-100.000', '12.000', '-100.000', 1, 'sale', 0),
(32, 1, 1, '2017-06-01 13:43:55', 'GRN 0005', 3, '1000.000', '10.000', '1991.000', 1, 'purchase', 0),
(33, 2, 1, '2017-06-01 13:43:55', 'GRN 0005', 3, '1000.000', '11.000', '1990.000', 1, 'purchase', 0),
(34, 4, 1, '2017-06-01 13:43:55', 'GRN 0005', 3, '1000.000', '10.000', '3000.000', 1, 'purchase', 0),
(35, 5, 1, '2017-06-01 13:43:55', 'GRN 0005', 3, '1000.000', '10.000', '1990.000', 1, 'purchase', 0),
(36, 6, 1, '2017-06-01 13:43:55', 'GRN 0005', 3, '1000.000', '10.000', '1900.000', 1, 'purchase', 0),
(37, 1, 1, '2017-06-01 14:02:51', 'GRN 0006', 3, '1000.000', '10.000', '2991.000', 1, 'purchase', 0),
(38, 2, 1, '2017-06-01 14:02:51', 'GRN 0006', 3, '1000.000', '11.000', '2990.000', 1, 'purchase', 0),
(39, 4, 1, '2017-06-01 14:02:51', 'GRN 0006', 3, '1000.000', '10.000', '4000.000', 1, 'purchase', 0),
(40, 5, 1, '2017-06-01 14:02:51', 'GRN 0006', 3, '1000.000', '10.000', '2990.000', 1, 'purchase', 0),
(41, 6, 1, '2017-06-01 14:02:51', 'GRN 0006', 3, '1000.000', '10.000', '2900.000', 1, 'purchase', 0),
(42, 1, 1, '2017-06-05 12:10:11', 'GRN 0007', 2, '11.000', '10.000', '11.000', 1, 'purchase', 0),
(43, 2, 1, '2017-06-05 12:10:11', 'GRN 0007', 2, '10.000', '11.000', '10.000', 1, 'purchase', 0),
(44, 4, 1, '2017-06-05 12:10:11', 'GRN 0007', 2, '10.000', '10.000', '10.000', 1, 'purchase', 0),
(45, 1, 1, '2017-06-06 13:23:53', '', 2, '567567.000', '10.000', '567578.000', 1, 'damage', 1),
(46, 1, 1, '2017-06-06 14:52:08', 'GRN 0008', 2, '11.000', '10.000', '567589.000', 1, 'purchase', 0),
(47, 2, 1, '2017-06-06 14:52:08', 'GRN 0008', 2, '10.000', '11.000', '20.000', 1, 'purchase', 0),
(48, 4, 1, '2017-06-06 14:52:08', 'GRN 0008', 2, '10.000', '10.000', '20.000', 1, 'purchase', 0),
(49, 1, 1, '2017-06-12 12:53:42', 'SOK 6', 4, '-1.000', '12.000', '-1.000', 1, 'sale', 0),
(50, 1, 1, '2017-06-12 12:54:27', 'SOK 7', 4, '-1.000', '12.000', '-2.000', 1, 'sale', 0),
(51, 1, 1, '2017-06-12 12:56:51', 'SOK 8', 4, '-1.000', '12.000', '-3.000', 1, 'sale', 0),
(52, 1, 1, '2017-06-12 13:04:59', 'GRN 0009', 2, '11.000', '10.000', '567600.000', 1, 'purchase', 0),
(53, 2, 1, '2017-06-12 13:04:59', 'GRN 0009', 2, '10.000', '11.000', '30.000', 1, 'purchase', 0),
(54, 4, 1, '2017-06-12 13:04:59', 'GRN 0009', 2, '10.000', '10.000', '30.000', 1, 'purchase', 0),
(55, 1, 1, '2017-06-12 13:09:20', 'GRN 0010', 2, '10.000', '10.000', '567610.000', 1, 'purchase', 0),
(56, 1, 1, '2017-06-12 14:26:16', 'SOK 9', 4, '-2.000', '12.000', '-5.000', 1, 'sale', 0),
(57, 2, 1, '2017-06-12 14:28:27', 'SOK 10', 4, '-1.000', '13.000', '-1.000', 1, 'sale', 0),
(58, 4, 1, '2017-06-12 14:37:05', 'GRN 0011', 2, '15.000', '10.000', '45.000', 1, 'purchase', 0),
(59, 1, 1, '2017-06-12 14:42:21', 'GRN 0012', 2, '9.000', '10.000', '567619.000', 1, 'purchase', 0),
(60, 1, 1, '2017-06-12 14:50:07', 'GRN 0013', 2, '1.000', '10.000', '567620.000', 1, 'purchase', 0),
(61, 1, 1, '2017-06-12 14:52:05', 'GRN 0014', 2, '200.000', '10.000', '567820.000', 1, 'purchase', 0),
(62, 1, 1, '2017-06-12 14:52:41', 'GRN 0015', 2, '200.000', '10.000', '568020.000', 1, 'purchase', 0),
(63, 1, 1, '2017-06-12 14:57:22', '4353', 2, '91.000', '10.000', '568111.000', 1, 'damage', 2),
(64, 1, 1, '2017-06-12 14:57:36', '', 2, '-43.000', '10.000', '568068.000', 1, 'damage', 2),
(65, 1, 1, '2017-06-12 14:58:13', 'REQ 0003', 2, '-25.000', '10.000', '568043.000', 1, 'sale', 0),
(66, 2, 1, '2017-06-12 14:58:13', 'REQ 0003', 2, '-2.000', '10.000', '28.000', 1, 'sale', 0),
(67, 4, 1, '2017-06-12 15:00:48', 'SOK 11', 6, '-4.000', '15.000', '-4.000', 1, 'sale', 0),
(68, 4, 1, '2017-06-12 15:03:09', 'SOK 12', 6, '-5.000', '15.000', '-9.000', 1, 'sale', 0),
(69, 4, 1, '2017-06-12 15:17:42', 'SOK 13', 6, '-1.000', '15.000', '-10.000', 1, 'sale', 0),
(70, 4, 1, '2017-06-12 15:21:00', 'SOK 14', 6, '-1.000', '15.000', '-11.000', 1, 'sale', 0),
(71, 4, 1, '2017-06-12 15:29:22', 'GRN 0016', 3, '25.000', '10.000', '4025.000', 1, 'purchase', 0),
(72, 4, 1, '2017-06-12 15:30:24', 'GRN 0017', 3, '2.000', '10.000', '4027.000', 1, 'purchase', 0),
(73, 4, 1, '2017-06-12 15:30:57', 'GRN 0018', 3, '3.000', '10.000', '4030.000', 1, 'purchase', 0),
(74, 5, 1, '2017-06-12 15:36:42', 'REQ 0004', 3, '-15.000', '10.000', '2975.000', 1, 'sale', 0),
(75, 1, 1, '2017-06-12 15:38:35', 'REQ 0005', 3, '-20.000', '10.000', '2971.000', 1, 'sale', 0),
(76, 1, 1, '2017-06-13 06:32:35', 'Manual Edit of Quantity', 6, '100.000', '10.000', '0.000', 1, 'damage', 0),
(77, 1, 1, '2017-06-13 06:32:35', 'Manual Edit of Quantity', 4, '5.000', '10.000', '0.000', 1, 'damage', 0),
(78, 2, 1, '2017-06-14 06:16:24', 'GRN 0019', 2, '50.000', '11.000', '78.000', 1, 'purchase', 0),
(79, 2, 1, '2017-06-14 06:33:32', 'GRN 0020', 2, '50.000', '11.000', '128.000', 1, 'purchase', 0),
(80, 1, 55, '2017-06-14 14:54:03', 'GRN 0021', 2, '10.000', '10.000', '568053.000', 55, 'purchase', 0),
(81, 2, 55, '2017-06-14 14:54:03', 'GRN 0021', 2, '10.000', '11.000', '138.000', 55, 'purchase', 0),
(82, 3, 55, '2017-06-14 14:54:03', 'GRN 0021', 2, '10.000', '12.000', '10.000', 55, 'purchase', 0),
(83, 4, 55, '2017-06-14 14:54:03', 'GRN 0021', 2, '10.000', '10.000', '55.000', 55, 'purchase', 0),
(84, 4, 55, '2017-06-14 14:54:35', 'GRN 0022', 2, '10.000', '10.000', '65.000', 55, 'purchase', 0),
(85, 3, 1, '2017-06-15 07:45:21', 'SOK 15', 6, '-2.000', '14.000', '-2.000', 1, 'sale', 0),
(86, 2, 1, '2017-06-15 07:45:21', 'SOK 15', 6, '-2.000', '13.000', '-2.000', 1, 'sale', 0),
(87, 1, 1, '2017-06-15 07:45:21', 'SOK 15', 6, '-1.000', '12.000', '-1.000', 1, 'sale', 0),
(88, 2, 1, '2017-06-15 09:12:43', 'Manual Edit of Quantity', 6, '2.000', '11.000', '0.000', 1, 'damage', 0),
(89, 2, 1, '2017-06-15 09:12:43', 'Manual Edit of Quantity', 4, '1.000', '11.000', '0.000', 1, 'damage', 0),
(90, 10, 1, '2017-06-15 09:15:37', 'Manual Edit of Quantity', 6, '0.000', '12.000', '0.000', 1, 'damage', 0),
(91, 10, 1, '2017-06-15 09:15:38', 'Manual Edit of Quantity', 8, '0.000', '12.000', '0.000', 1, 'damage', 0),
(92, 10, 1, '2017-06-15 09:15:38', 'Manual Edit of Quantity', 5, '0.000', '12.000', '0.000', 1, 'damage', 0),
(93, 10, 1, '2017-06-15 09:15:38', 'Manual Edit of Quantity', 4, '0.000', '12.000', '0.000', 1, 'damage', 0),
(94, 10, 1, '2017-06-15 09:15:39', 'Manual Edit of Quantity', 2, '0.000', '12.000', '0.000', 1, 'damage', 0),
(95, 10, 1, '2017-06-15 09:15:39', 'Manual Edit of Quantity', 3, '0.000', '12.000', '0.000', 1, 'damage', 0),
(96, 11, 1, '2017-06-15 09:15:40', 'Manual Edit of Quantity', 6, '0.000', '12.000', '0.000', 1, 'damage', 0),
(97, 11, 1, '2017-06-15 09:15:40', 'Manual Edit of Quantity', 8, '0.000', '12.000', '0.000', 1, 'damage', 0),
(98, 11, 1, '2017-06-15 09:15:40', 'Manual Edit of Quantity', 5, '0.000', '12.000', '0.000', 1, 'damage', 0),
(99, 11, 1, '2017-06-15 09:15:41', 'Manual Edit of Quantity', 4, '0.000', '12.000', '0.000', 1, 'damage', 0),
(100, 11, 1, '2017-06-15 09:15:41', 'Manual Edit of Quantity', 2, '0.000', '12.000', '0.000', 1, 'damage', 0),
(101, 11, 1, '2017-06-15 09:15:41', 'Manual Edit of Quantity', 3, '0.000', '12.000', '0.000', 1, 'damage', 0),
(102, 10, 1, '2017-06-15 09:18:05', 'Manual Edit of Quantity', 6, '5.000', '12.000', '5.000', 1, 'damage', 0),
(103, 10, 1, '2017-06-15 09:18:05', 'Manual Edit of Quantity', 8, '6.000', '12.000', '6.000', 1, 'damage', 0),
(104, 10, 1, '2017-06-15 09:18:06', 'Manual Edit of Quantity', 2, '20.000', '12.000', '20.000', 1, 'damage', 0),
(105, 10, 1, '2017-06-15 09:18:06', 'Manual Edit of Quantity', 3, '21.000', '12.000', '21.000', 1, 'damage', 0),
(106, 10, 1, '2017-06-15 09:32:44', 'SOK 16', 6, '-3.000', '13.000', '2.000', 1, 'sale', 0),
(107, 10, 1, '2017-06-15 11:24:41', 'GRN 0023', 2, '20.000', '12.000', '40.000', 1, 'purchase', 0),
(108, 10, 1, '2017-06-15 11:32:23', '10 out of 40  stocks on fire\n', 2, '10.000', '12.000', '50.000', 1, 'damage', 3),
(109, 10, 1, '2017-06-15 12:05:59', 'GRN 0024', 2, '5.000', '12.000', '55.000', 1, 'purchase', 0),
(110, 10, 1, '2017-06-15 12:42:27', '50 damaged in the stock on the fire', 2, '50.000', '12.000', '105.000', 1, 'damage', 3),
(111, 12, 1, '2017-06-15 12:44:26', 'Manual Edit of Quantity', 6, '0.000', '0.000', '0.000', 1, 'damage', 0),
(112, 12, 1, '2017-06-15 12:44:27', 'Manual Edit of Quantity', 8, '0.000', '0.000', '0.000', 1, 'damage', 0),
(113, 12, 1, '2017-06-15 12:44:27', 'Manual Edit of Quantity', 5, '0.000', '0.000', '0.000', 1, 'damage', 0),
(114, 12, 1, '2017-06-15 12:44:28', 'Manual Edit of Quantity', 4, '0.000', '0.000', '0.000', 1, 'damage', 0),
(115, 12, 1, '2017-06-15 12:44:28', 'Manual Edit of Quantity', 2, '0.000', '0.000', '0.000', 1, 'damage', 0),
(116, 12, 1, '2017-06-15 12:44:28', 'Manual Edit of Quantity', 3, '0.000', '0.000', '0.000', 1, 'damage', 0),
(117, 12, 1, '2017-06-15 12:48:34', 'Manual Edit of Quantity', 6, '10.000', '100.000', '10.000', 1, 'damage', 0),
(118, 12, 1, '2017-06-15 12:48:34', 'Manual Edit of Quantity', 2, '5.000', '100.000', '5.000', 1, 'damage', 0),
(119, 12, 1, '2017-06-15 12:59:06', '', 3, '0.000', '100.000', '0.000', 1, 'damage', 2),
(120, 13, 1, '2017-06-15 14:34:36', 'Manual Edit of Quantity', 6, '115.000', '1500.000', '115.000', 1, 'damage', 0),
(121, 13, 1, '2017-06-15 14:34:37', 'Manual Edit of Quantity', 8, '0.000', '1500.000', '0.000', 1, 'damage', 0),
(122, 13, 1, '2017-06-15 14:34:37', 'Manual Edit of Quantity', 5, '0.000', '1500.000', '0.000', 1, 'damage', 0),
(123, 13, 1, '2017-06-15 14:34:37', 'Manual Edit of Quantity', 4, '0.000', '1500.000', '0.000', 1, 'damage', 0),
(124, 13, 1, '2017-06-15 14:34:37', 'Manual Edit of Quantity', 2, '0.000', '1500.000', '0.000', 1, 'damage', 0),
(125, 13, 1, '2017-06-15 14:34:38', 'Manual Edit of Quantity', 3, '0.000', '1500.000', '0.000', 1, 'damage', 0),
(126, 13, 1, '2017-06-15 14:36:21', 'Manual Edit of Quantity', 6, '-100.000', '1500.000', '15.000', 1, 'damage', 0),
(127, 13, 1, '2017-06-15 14:36:21', 'Manual Edit of Quantity', 2, '12.000', '1500.000', '12.000', 1, 'damage', 0),
(128, 1, 1, '2017-06-15 14:46:20', 'GRN 0025', 2, '2.000', '10.000', '568055.000', 1, 'purchase', 0),
(129, 2, 1, '2017-06-15 14:46:20', 'GRN 0025', 2, '2.000', '11.000', '140.000', 1, 'purchase', 0),
(130, 3, 1, '2017-06-15 14:46:20', 'GRN 0025', 2, '2.000', '12.000', '12.000', 1, 'purchase', 0),
(131, 4, 1, '2017-06-15 14:46:20', 'GRN 0025', 2, '10.000', '10.000', '75.000', 1, 'purchase', 0),
(132, 4, 1, '2017-06-16 08:13:47', 'GRN 0026', 2, '10.000', '10.000', '85.000', 1, 'purchase', 0),
(133, 1, 1, '2017-06-19 07:25:22', 'Manual Edit of Quantity', 6, '1.000', '10.000', '0.000', 1, 'damage', 0),
(134, 14, 1, '2017-06-19 07:32:19', 'Manual Edit of Quantity', 6, '5.000', '100.000', '5.000', 1, 'damage', 0),
(135, 14, 1, '2017-06-19 07:32:19', 'Manual Edit of Quantity', 8, '6.000', '100.000', '6.000', 1, 'damage', 0),
(136, 14, 1, '2017-06-19 07:32:19', 'Manual Edit of Quantity', 5, '0.000', '100.000', '0.000', 1, 'damage', 0),
(137, 14, 1, '2017-06-19 07:32:20', 'Manual Edit of Quantity', 4, '0.000', '100.000', '0.000', 1, 'damage', 0),
(138, 14, 1, '2017-06-19 07:32:20', 'Manual Edit of Quantity', 2, '5.000', '100.000', '5.000', 1, 'damage', 0),
(139, 14, 1, '2017-06-19 07:32:20', 'Manual Edit of Quantity', 3, '0.000', '100.000', '0.000', 1, 'damage', 0),
(140, 15, 1, '2017-06-19 08:21:35', 'Manual Edit of Quantity', 6, '6.000', '25.000', '6.000', 1, 'damage', 0),
(141, 15, 1, '2017-06-19 08:21:35', 'Manual Edit of Quantity', 8, '0.000', '25.000', '0.000', 1, 'damage', 0),
(142, 15, 1, '2017-06-19 08:21:36', 'Manual Edit of Quantity', 5, '0.000', '25.000', '0.000', 1, 'damage', 0),
(143, 15, 1, '2017-06-19 08:21:36', 'Manual Edit of Quantity', 4, '0.000', '25.000', '0.000', 1, 'damage', 0),
(144, 15, 1, '2017-06-19 08:21:36', 'Manual Edit of Quantity', 2, '9.000', '25.000', '9.000', 1, 'damage', 0),
(145, 15, 1, '2017-06-19 08:21:36', 'Manual Edit of Quantity', 3, '0.000', '25.000', '0.000', 1, 'damage', 0),
(146, 14, 1, '2017-06-19 09:00:18', 'GRN 0027', 2, '1.000', '100.000', '6.000', 1, 'purchase', 0),
(147, 15, 1, '2017-06-19 09:03:47', 'GRN 0028', 2, '2.000', '25.000', '11.000', 1, 'purchase', 0),
(148, 1, 1, '2017-06-19 11:54:27', 'Comments', 2, '-67.000', '10.000', '567988.000', 1, 'damage', 4),
(149, 15, 1, '2017-06-19 12:34:28', 'GRN 0029', 2, '1.000', '25.000', '12.000', 1, 'purchase', 0),
(150, 15, 1, '2017-06-19 14:10:13', 'GRN 0030', 2, '2.000', '25.000', '14.000', 1, 'purchase', 0),
(151, 16, 1, '2017-06-19 14:18:37', 'Manual Edit of Quantity', 6, '0.000', '0.000', '0.000', 1, 'damage', 0),
(152, 16, 1, '2017-06-19 14:18:38', 'Manual Edit of Quantity', 8, '0.000', '0.000', '0.000', 1, 'damage', 0),
(153, 16, 1, '2017-06-19 14:18:38', 'Manual Edit of Quantity', 5, '0.000', '0.000', '0.000', 1, 'damage', 0),
(154, 16, 1, '2017-06-19 14:18:38', 'Manual Edit of Quantity', 4, '0.000', '0.000', '0.000', 1, 'damage', 0),
(155, 16, 1, '2017-06-19 14:18:39', 'Manual Edit of Quantity', 2, '0.000', '0.000', '0.000', 1, 'damage', 0),
(156, 16, 1, '2017-06-19 14:18:39', 'Manual Edit of Quantity', 3, '0.000', '0.000', '0.000', 1, 'damage', 0),
(157, 16, 1, '2017-06-19 14:19:44', 'Manual Edit of Quantity', 6, '6.000', '450.000', '6.000', 1, 'damage', 0),
(158, 16, 1, '2017-06-19 14:19:45', 'Manual Edit of Quantity', 2, '7.000', '450.000', '7.000', 1, 'damage', 0),
(159, 16, 1, '2017-06-19 14:28:21', 'GRN 0031', 2, '3.000', '450.000', '10.000', 1, 'purchase', 0),
(160, 16, 1, '2017-06-19 14:29:51', 'GRN 0032', 2, '1.000', '450.000', '11.000', 1, 'purchase', 0),
(161, 10, 1, '2017-06-20 12:07:47', 'GRN 0033', 2, '25.000', '12.000', '130.000', 1, 'purchase', 0),
(162, 16, 1, '2017-06-20 12:15:09', 'GRN 0034', 2, '4.000', '450.000', '15.000', 1, 'purchase', 0),
(163, 1, 1, '2017-06-20 15:14:29', 'REQ 0006', 2, '-25.000', '10.000', '567963.000', 1, 'sale', 0),
(164, 17, 1, '2017-06-21 06:24:10', 'Manual Edit of Quantity', 6, '0.000', '0.000', '0.000', 1, 'damage', 0),
(165, 17, 1, '2017-06-21 06:24:10', 'Manual Edit of Quantity', 8, '0.000', '0.000', '0.000', 1, 'damage', 0),
(166, 17, 1, '2017-06-21 06:24:10', 'Manual Edit of Quantity', 5, '0.000', '0.000', '0.000', 1, 'damage', 0),
(167, 17, 1, '2017-06-21 06:24:11', 'Manual Edit of Quantity', 4, '0.000', '0.000', '0.000', 1, 'damage', 0),
(168, 17, 1, '2017-06-21 06:24:11', 'Manual Edit of Quantity', 2, '0.000', '0.000', '0.000', 1, 'damage', 0),
(169, 17, 1, '2017-06-21 06:24:11', 'Manual Edit of Quantity', 3, '0.000', '0.000', '0.000', 1, 'damage', 0),
(170, 17, 1, '2017-06-21 06:27:35', 'Manual Edit of Quantity', 6, '10.000', '200.000', '10.000', 1, 'damage', 0),
(171, 17, 1, '2017-06-21 06:27:36', 'Manual Edit of Quantity', 2, '12.000', '200.000', '12.000', 1, 'damage', 0),
(172, 17, 1, '2017-06-21 06:45:36', 'REQ 0007', 3, '-3.000', '0.000', '-3.000', 1, 'sale', 0),
(173, 17, 1, '2017-06-21 06:47:32', 'SOC 0003', 6, '3.000', '0.000', '13.000', 1, 'purchase', 0),
(174, 17, 1, '2017-06-21 06:50:25', 'REQ 0008', 2, '-3.000', '190.000', '9.000', 1, 'sale', 0),
(175, 17, 1, '2017-06-21 06:50:41', 'SOC 0004', 6, '3.000', '190.000', '16.000', 1, 'purchase', 0),
(176, 17, 1, '2017-06-21 06:53:30', 'Manual Edit of Quantity', 3, '3.000', '200.000', '0.000', 1, 'damage', 0),
(177, 18, 1, '2017-06-21 07:12:17', 'Manual Edit of Quantity', 6, '12.000', '120.000', '12.000', 1, 'damage', 0),
(178, 18, 1, '2017-06-21 07:12:17', 'Manual Edit of Quantity', 8, '0.000', '120.000', '0.000', 1, 'damage', 0),
(179, 18, 1, '2017-06-21 07:12:17', 'Manual Edit of Quantity', 5, '0.000', '120.000', '0.000', 1, 'damage', 0),
(180, 18, 1, '2017-06-21 07:12:17', 'Manual Edit of Quantity', 4, '0.000', '120.000', '0.000', 1, 'damage', 0),
(181, 18, 1, '2017-06-21 07:12:18', 'Manual Edit of Quantity', 2, '6.000', '120.000', '6.000', 1, 'damage', 0),
(182, 18, 1, '2017-06-21 07:12:18', 'Manual Edit of Quantity', 3, '0.000', '120.000', '0.000', 1, 'damage', 0),
(183, 18, 1, '2017-06-21 07:13:24', 'REQ 0009', 2, '-3.000', '115.000', '3.000', 1, 'sale', 0),
(184, 18, 1, '2017-06-21 07:14:32', 'SOC 0005', 6, '1.000', '115.000', '13.000', 1, 'purchase', 0),
(185, 18, 1, '2017-06-21 07:16:41', 'Manual Edit of Quantity', 6, '2.000', '120.000', '15.000', 1, 'damage', 0),
(186, 18, 1, '2017-06-21 07:16:41', 'Manual Edit of Quantity', 2, '9.000', '120.000', '12.000', 1, 'damage', 0),
(187, 18, 1, '2017-06-21 07:18:02', 'REQ 0010', 2, '-4.000', '115.000', '8.000', 1, 'sale', 0),
(188, 18, 1, '2017-06-21 07:18:41', 'SOC 0006', 6, '4.000', '115.000', '19.000', 1, 'purchase', 0),
(189, 18, 1, '2017-06-21 07:31:18', 'test 4 damaged', 2, '4.000', '120.000', '12.000', 1, 'damage', 1),
(190, 12, 1, '2017-06-21 07:33:13', 'terew', 2, '2.000', '100.000', '7.000', 1, 'damage', 3),
(191, 3, 1, '2017-06-21 07:39:38', '14', 2, '2.000', '12.000', '14.000', 1, 'damage', 2),
(192, 13, 1, '2017-06-21 07:40:36', 'e18', 2, '6.000', '1500.000', '18.000', 1, 'damage', 1),
(193, 13, 1, '2017-06-21 07:48:04', 'teste', 2, '6.000', '1500.000', '24.000', 1, 'damage', 2),
(194, 13, 1, '2017-06-21 07:59:00', 'REQ 0011', 2, '-1.000', '950.000', '23.000', 1, 'sale', 0),
(195, 13, 1, '2017-06-21 07:59:32', 'SOC 0007', 6, '1.000', '950.000', '16.000', 1, 'purchase', 0),
(196, 13, 1, '2017-06-21 08:14:27', 'GRN 0035', 2, '1.000', '1500.000', '24.000', 1, 'purchase', 0),
(197, 13, 1, '2017-06-21 08:18:51', 'Manual Edit of Quantity', 5, '10.000', '1500.000', '10.000', 1, 'damage', 0),
(198, 13, 1, '2017-06-21 08:20:22', 'REQ 0012', 2, '-1.000', '950.000', '23.000', 1, 'sale', 0),
(199, 13, 1, '2017-06-21 08:20:59', 'SOC 0008', 5, '1.000', '950.000', '11.000', 1, 'purchase', 0),
(200, 19, 1, '2017-06-21 08:32:59', 'Manual Edit of Quantity', 6, '0.000', '0.000', '0.000', 1, 'damage', 0),
(201, 19, 1, '2017-06-21 08:32:59', 'Manual Edit of Quantity', 8, '0.000', '0.000', '0.000', 1, 'damage', 0),
(202, 19, 1, '2017-06-21 08:33:00', 'Manual Edit of Quantity', 5, '0.000', '0.000', '0.000', 1, 'damage', 0),
(203, 19, 1, '2017-06-21 08:33:00', 'Manual Edit of Quantity', 4, '0.000', '0.000', '0.000', 1, 'damage', 0),
(204, 19, 1, '2017-06-21 08:33:00', 'Manual Edit of Quantity', 2, '0.000', '0.000', '0.000', 1, 'damage', 0),
(205, 19, 1, '2017-06-21 08:33:00', 'Manual Edit of Quantity', 3, '0.000', '0.000', '0.000', 1, 'damage', 0),
(206, 19, 1, '2017-06-21 08:49:54', 'Manual Edit of Quantity', 6, '9.000', '20000.000', '9.000', 1, 'damage', 0),
(207, 19, 1, '2017-06-21 08:49:55', 'Manual Edit of Quantity', 5, '9.000', '20000.000', '9.000', 1, 'damage', 0),
(208, 19, 1, '2017-06-21 08:49:55', 'Manual Edit of Quantity', 3, '10.000', '20000.000', '10.000', 1, 'damage', 0),
(209, 13, 1, '2017-06-21 13:54:02', 'SOK 17', 6, '-1.000', '1000.000', '15.000', 1, 'sale', 0),
(210, 13, 1, '2017-06-21 13:59:07', 'SOK 18', 6, '-1.000', '1000.000', '14.000', 1, 'sale', 0),
(211, 13, 1, '2017-06-21 14:05:05', 'SOK 19', 6, '-1.000', '1000.000', '13.000', 1, 'sale', 0),
(212, 13, 1, '2017-06-21 14:07:01', 'SOK 20', 6, '-1.000', '1000.000', '12.000', 1, 'sale', 0),
(213, 20, 1, '2017-06-22 06:12:00', 'Manual Edit of Quantity', 6, '4.000', '2000.000', '4.000', 1, 'damage', 0),
(214, 20, 1, '2017-06-22 06:12:00', 'Manual Edit of Quantity', 8, '0.000', '2000.000', '0.000', 1, 'damage', 0),
(215, 20, 1, '2017-06-22 06:12:00', 'Manual Edit of Quantity', 5, '4.000', '2000.000', '4.000', 1, 'damage', 0),
(216, 20, 1, '2017-06-22 06:12:00', 'Manual Edit of Quantity', 4, '0.000', '2000.000', '0.000', 1, 'damage', 0),
(217, 20, 1, '2017-06-22 06:12:01', 'Manual Edit of Quantity', 2, '5.000', '2000.000', '5.000', 1, 'damage', 0),
(218, 20, 1, '2017-06-22 06:12:01', 'Manual Edit of Quantity', 3, '0.000', '2000.000', '0.000', 1, 'damage', 0),
(219, 20, 1, '2017-06-22 06:13:34', 'SOK 21', 6, '-2.000', '2200.000', '2.000', 1, 'sale', 0),
(220, 20, 1, '2017-06-22 06:21:19', 'SOK 22', 6, '1.000', '2200.000', '3.000', 1, 'sale', 0),
(221, 20, 1, '2017-06-22 06:22:56', 'SOK 23', 5, '-1.000', '2200.000', '3.000', 1, 'sale', 0),
(222, 20, 1, '2017-06-22 07:11:01', 'SOK 24', 5, '-1.000', '2200.000', '2.000', 1, 'sale', 0),
(223, 19, 1, '2017-06-22 07:11:01', 'SOK 24', 5, '-1.000', '10000.000', '8.000', 1, 'sale', 0),
(224, 20, 1, '2017-06-22 07:11:01', 'SOK 25', 5, '-1.000', '2200.000', '1.000', 1, 'sale', 0),
(225, 19, 1, '2017-06-22 07:11:01', 'SOK 25', 5, '-1.000', '10000.000', '7.000', 1, 'sale', 0),
(226, 13, 1, '2017-06-22 09:06:32', 'SOK 26', 5, '-1.000', '1000.000', '10.000', 1, 'sale', 0),
(227, 13, 1, '2017-06-22 11:15:41', 'SOK 27', 5, '-1.000', '1000.000', '9.000', 1, 'sale', 0),
(228, 13, 1, '2017-06-22 11:28:43', 'SOK 28', 5, '-1.000', '1000.000', '8.000', 1, 'sale', 0),
(229, 13, 1, '2017-06-22 11:32:21', 'SOK 29', 6, '-2.000', '1000.000', '10.000', 1, 'sale', 0),
(230, 13, 1, '2017-06-22 11:33:44', 'SOK 30', 6, '-1.000', '1000.000', '9.000', 1, 'sale', 0),
(231, 13, 1, '2017-06-22 11:38:39', 'SOK 31', 6, '-1.000', '1000.000', '8.000', 1, 'sale', 0),
(232, 20, 1, '2017-06-22 12:21:09', 'SOK 32', 5, '-1.000', '2200.000', '0.000', 1, 'sale', 0),
(233, 20, 1, '2017-06-22 12:52:29', 'SOK 33', 5, '-1.000', '2200.000', '-1.000', 1, 'sale', 0),
(234, 13, 1, '2017-06-22 13:43:48', 'SOK 34', 6, '-1.000', '1000.000', '7.000', 1, 'sale', 0),
(235, 13, 1, '2017-06-23 12:59:58', 'REQ 0013', 3, '-1.000', '0.000', '-1.000', 1, 'sale', 0),
(236, 12, 1, '2017-06-23 13:01:11', 'REQ 0014', 2, '-5.000', '105.000', '2.000', 1, 'sale', 0),
(237, 2, 1, '2017-06-23 13:18:10', 'REQ 0015', 2, '-6.000', '10.000', '134.000', 1, 'sale', 0),
(238, 2, 1, '2017-06-23 13:19:01', 'SOC 0009', 6, '4.000', '10.000', '4.000', 1, 'purchase', 0),
(239, 13, 1, '2017-06-23 15:29:14', 'REQ 0016', 2, '-3.000', '950.000', '20.000', 1, 'sale', 0),
(240, 13, 1, '2017-06-24 06:21:29', 'REQ 0017', 2, '-1.000', '950.000', '19.000', 1, 'sale', 0),
(241, 13, 1, '2017-06-24 06:30:26', 'REQ 0018', 2, '-2.000', '950.000', '17.000', 1, 'sale', 0),
(242, 13, 1, '2017-06-24 06:31:22', 'SOC 0010', 6, '2.000', '950.000', '9.000', 1, 'purchase', 0),
(243, 13, 1, '2017-06-24 06:33:03', 'REQ 0019', 2, '-2.000', '950.000', '15.000', 1, 'sale', 0),
(244, 13, 1, '2017-06-24 06:33:36', 'SOC 0011', 6, '2.000', '950.000', '11.000', 1, 'purchase', 0),
(245, 6, 1, '2017-06-24 06:41:57', 'REQ 0020', 3, '-200.000', '10.000', '2700.000', 1, 'sale', 0),
(246, 6, 1, '2017-06-24 09:03:48', 'SOC 0012', 6, '200.000', '10.000', '200.000', 1, 'purchase', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_inventory_adjustments`
--

CREATE TABLE `ospos_inventory_adjustments` (
  `id` int(11) NOT NULL,
  `text` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_inventory_adjustments`
--

INSERT INTO `ospos_inventory_adjustments` (`id`, `text`) VALUES
(1, 'Damaged goods'),
(2, 'Missing goods'),
(3, 'Stock on fire'),
(4, 'Inventory Revaluation');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_items`
--

CREATE TABLE `ospos_items` (
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `cost_price` decimal(15,2) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `reorder_level` decimal(15,3) NOT NULL DEFAULT '0.000',
  `receiving_quantity` decimal(15,3) NOT NULL DEFAULT '1.000',
  `item_id` int(10) NOT NULL,
  `pic_filename` varchar(255) DEFAULT NULL,
  `allow_alt_description` tinyint(1) NOT NULL,
  `is_serialized` tinyint(1) NOT NULL,
  `stock_type` tinyint(2) NOT NULL DEFAULT '0',
  `item_type` tinyint(2) NOT NULL DEFAULT '0',
  `tax_category_id` int(10) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `custom1` varchar(25) NOT NULL,
  `custom2` varchar(25) NOT NULL,
  `custom3` varchar(25) NOT NULL,
  `custom4` varchar(25) NOT NULL,
  `custom5` varchar(25) NOT NULL,
  `custom6` varchar(25) NOT NULL,
  `custom7` varchar(25) NOT NULL,
  `custom8` varchar(25) NOT NULL,
  `custom9` varchar(25) NOT NULL,
  `custom10` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_items`
--

INSERT INTO `ospos_items` (`name`, `category`, `supplier_id`, `item_number`, `description`, `cost_price`, `unit_price`, `reorder_level`, `receiving_quantity`, `item_id`, `pic_filename`, `allow_alt_description`, `is_serialized`, `stock_type`, `item_type`, `tax_category_id`, `deleted`, `custom1`, `custom2`, `custom3`, `custom4`, `custom5`, `custom6`, `custom7`, `custom8`, `custom9`, `custom10`) VALUES
('Apple iPhone6', 'Mobile Phones', 14, '8789797777', '', '10.00', '12.00', '20.000', '10.000', 1, 'iphone1.jpg', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Digital Cameras', 'Mobile Phones', NULL, 'D53563636', '', '11.00', '13.00', '10.000', '10.000', 2, 'cameras1.jpg', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('LCD TVs', 'Mobile Phones', NULL, 'LB87979', '', '12.00', '14.00', '10.000', '10.000', 3, 'lcd1.JPG', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('MP3 & MP4 Player', 'Mobile Phones', NULL, 'MP43636363', '', '10.00', '15.00', '10.000', '10.000', 4, 'mp3player1.jpg', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Pen Drives', 'Mobile Phones', NULL, 'PN879797', '', '10.00', '14.00', '10.000', '10.000', 5, 'pendrive1.jpg', 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Testing', 'Mobile Phones', NULL, 'TESTING', '', '10.00', '13.00', '10.000', '10.000', 6, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('', '', NULL, NULL, '', '0.00', '0.00', '0.000', '0.000', 7, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('', '', NULL, NULL, '', '0.00', '0.00', '0.000', '0.000', 8, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('', '', NULL, NULL, '', '0.00', '0.00', '0.000', '0.000', 9, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Pen', 'Pen', 12, 'P0024636723', 'Productname is Pen ', '12.00', '13.00', '10.000', '25.000', 10, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Pen', 'Pen', 12, NULL, '', '12.00', '13.00', '0.000', '0.000', 11, NULL, 0, 0, 0, 0, 0, 1, '', '', '', '', '', '', '', '', '', ''),
('Selfiestick', 'Mobile category', 14, 'Product10001', 'Product name : Selfiestick', '100.00', '120.00', '2.000', '10.000', 12, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Watch', 'Accessories', 14, 'PO 00034', '', '1500.00', '1000.00', '0.000', '0.000', 13, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Story Book', 'Books', 12, '978-1-4028-9462-6', 'test description...test description...test description...test description...test description...test description...test description...test description...test description...test description...test description...test description...test description...', '100.00', '120.00', '90.000', '0.000', 14, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Note book', 'Books', 12, 'PN00031', '', '25.00', '20.00', '22.000', '0.000', 15, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Bag', 'Accessories', 11, 'Prnum 001662017', 'test descr', '450.00', '400.00', '10.000', '0.000', 16, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Coolers', 'Home Appliances', 14, 'ISBN 01234', 'testersdfrerwer', '200.00', '150.00', '7.000', '3.000', 17, 'coolers.jpg', 1, 1, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('sm', 'smc', 13, 'sample', 'test', '120.00', '100.00', '100.000', '0.000', 18, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('Air conditioner', 'Home Appliances', 14, 'UPC00124', 'AC', '20000.00', '10000.00', '0.000', '0.000', 19, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', ''),
('MOBILE', 'Mobile category', 14, 'Product123', '', '2000.00', '2200.00', '0.000', '0.000', 20, NULL, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_items_taxes`
--

CREATE TABLE `ospos_items_taxes` (
  `item_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_items_taxes`
--

INSERT INTO `ospos_items_taxes` (`item_id`, `name`, `percent`) VALUES
(1, 'Laos at a standard rate', '10.000'),
(2, 'Laos at a standard rate', '10.000'),
(3, 'Laos at a standard rate', '10.000'),
(4, 'Laos at a standard rate', '10.000'),
(5, 'Laos at a standard rate', '10.000'),
(6, 'Laos at a standard rate', '10.000'),
(7, 'Laos at a standard rate', '10.000'),
(8, 'Laos at a standard rate', '10.000'),
(9, 'Laos at a standard rate', '10.000'),
(10, 'Laos at a standard rate', '10.000'),
(11, 'Laos at a standard rate', '10.000'),
(12, 'Laos at a standard rate', '10.000'),
(13, 'Laos at a standard rate', '10.000'),
(14, 'Laos at a standard rate', '10.000'),
(15, 'Laos at a standard rate', '10.000'),
(16, 'Laos at a standard rate', '10.000'),
(17, 'Laos at a standard rate', '10.000'),
(18, 'Laos at a standard rate', '10.000'),
(19, 'Laos at a standard rate', '20.000'),
(20, 'Laos at a standard rate', '10.000');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_item_kits`
--

CREATE TABLE `ospos_item_kits` (
  `item_kit_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `item_id` int(10) NOT NULL DEFAULT '0',
  `kit_discount_percent` decimal(15,2) NOT NULL DEFAULT '0.00',
  `price_option` tinyint(2) NOT NULL DEFAULT '0',
  `print_option` tinyint(2) NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_item_kits`
--

INSERT INTO `ospos_item_kits` (`item_kit_id`, `name`, `item_id`, `kit_discount_percent`, `price_option`, `print_option`, `description`) VALUES
(1, 'dgf', 0, '54654.00', 0, 2, '456');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_item_kit_items`
--

CREATE TABLE `ospos_item_kit_items` (
  `item_kit_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` decimal(15,3) NOT NULL,
  `kit_sequence` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_item_kit_items`
--

INSERT INTO `ospos_item_kit_items` (`item_kit_id`, `item_id`, `quantity`, `kit_sequence`) VALUES
(1, 1, '1.000', 0),
(1, 2, '1.000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_item_price`
--

CREATE TABLE `ospos_item_price` (
  `item_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `price` decimal(15,3) NOT NULL DEFAULT '0.000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_item_price`
--

INSERT INTO `ospos_item_price` (`item_id`, `location_id`, `price`) VALUES
(1, 1, '10.000'),
(1, 2, '10.000'),
(1, 3, '10.000'),
(1, 4, '10.000'),
(1, 5, '10.000'),
(1, 6, '10.000'),
(1, 7, '10.000'),
(1, 8, '10.000'),
(1, 9, '10.000'),
(2, 1, '10.000'),
(2, 2, '10.000'),
(2, 3, '10.000'),
(2, 4, '10.000'),
(2, 5, '10.000'),
(2, 6, '10.000'),
(2, 7, '10.000'),
(2, 8, '10.000'),
(2, 9, '10.000'),
(3, 1, '10.000'),
(3, 2, '10.000'),
(3, 3, '10.000'),
(3, 4, '10.000'),
(3, 5, '10.000'),
(3, 6, '10.000'),
(3, 7, '10.000'),
(3, 8, '10.000'),
(3, 9, '10.000'),
(4, 1, '10.000'),
(4, 2, '10.000'),
(4, 3, '10.000'),
(4, 4, '10.000'),
(4, 5, '10.000'),
(4, 6, '10.000'),
(4, 7, '10.000'),
(4, 8, '10.000'),
(4, 9, '10.000'),
(5, 1, '10.000'),
(5, 2, '10.000'),
(5, 3, '10.000'),
(5, 4, '10.000'),
(5, 5, '10.000'),
(5, 6, '10.000'),
(5, 7, '10.000'),
(5, 8, '10.000'),
(5, 9, '10.000'),
(6, 2, '10.000'),
(6, 3, '10.000'),
(6, 4, '16.000'),
(6, 5, '15.000'),
(6, 6, '14.000'),
(6, 8, '14.000'),
(10, 2, '11.000'),
(10, 3, '12.000'),
(10, 4, '0.000'),
(10, 5, '0.000'),
(10, 6, '10.000'),
(10, 8, '11.000'),
(11, 2, '0.000'),
(11, 3, '0.000'),
(11, 4, '0.000'),
(11, 5, '0.000'),
(11, 6, '0.000'),
(11, 8, '0.000'),
(12, 2, '105.000'),
(12, 3, '0.000'),
(12, 4, '0.000'),
(12, 5, '0.000'),
(12, 6, '110.000'),
(12, 8, '0.000'),
(13, 2, '950.000'),
(13, 3, '0.000'),
(13, 4, '0.000'),
(13, 5, '1000.000'),
(13, 6, '1000.000'),
(13, 8, '0.000'),
(14, 2, '130.000'),
(14, 3, '0.000'),
(14, 4, '0.000'),
(14, 5, '0.000'),
(14, 6, '110.000'),
(14, 8, '110.000'),
(15, 2, '22.000'),
(15, 3, '0.000'),
(15, 4, '0.000'),
(15, 5, '0.000'),
(15, 6, '23.000'),
(15, 8, '0.000'),
(16, 2, '320.000'),
(16, 3, '0.000'),
(16, 4, '0.000'),
(16, 5, '0.000'),
(16, 6, '350.000'),
(16, 8, '0.000'),
(17, 2, '190.000'),
(17, 3, '0.000'),
(17, 4, '0.000'),
(17, 5, '0.000'),
(17, 6, '180.000'),
(17, 8, '0.000'),
(18, 2, '115.000'),
(18, 3, '0.000'),
(18, 4, '0.000'),
(18, 5, '0.000'),
(18, 6, '105.000'),
(18, 8, '0.000'),
(19, 2, '0.000'),
(19, 3, '19500.000'),
(19, 4, '0.000'),
(19, 5, '19000.000'),
(19, 6, '19000.000'),
(19, 8, '0.000'),
(20, 2, '2350.000'),
(20, 3, '0.000'),
(20, 4, '0.000'),
(20, 5, '2300.000'),
(20, 6, '2300.000'),
(20, 8, '0.000');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_item_promo`
--

CREATE TABLE `ospos_item_promo` (
  `id` int(11) NOT NULL,
  `promo_name` varchar(200) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  `fromdate` datetime DEFAULT NULL,
  `todate` datetime DEFAULT NULL,
  `promo_type` enum('price','percentage') NOT NULL,
  `price` float(15,5) NOT NULL DEFAULT '0.00000',
  `item_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_item_promo`
--

INSERT INTO `ospos_item_promo` (`id`, `promo_name`, `note`, `fromdate`, `todate`, `promo_type`, `price`, `item_id`, `location_id`, `employee_id`, `date_time`, `status`) VALUES
(1, '456456', NULL, '2010-01-01 00:00:00', '2017-06-30 00:00:00', 'price', 46546.00000, 1, 6, 1, '2017-06-09 11:47:27', 0),
(2, '456456', NULL, '2010-01-01 00:00:00', '2017-06-30 00:00:00', 'price', 46546.00000, 2, 6, 1, '2017-06-09 11:47:27', 0),
(3, '456456', NULL, '2010-01-01 00:00:00', '2017-06-30 00:00:00', 'price', 46546.00000, 4, 6, 1, '2017-06-09 11:47:27', 0),
(4, '456456', NULL, '2010-01-01 00:00:00', '2017-06-30 00:00:00', 'price', 46546.00000, 1, 8, 1, '2017-06-09 11:47:27', 0),
(5, '456456', NULL, '2010-01-01 00:00:00', '2017-06-30 00:00:00', 'price', 46546.00000, 2, 8, 1, '2017-06-09 11:47:27', 0),
(6, '456456', NULL, '2010-01-01 00:00:00', '2017-06-30 00:00:00', 'price', 46546.00000, 4, 8, 1, '2017-06-09 11:47:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_item_quantities`
--

CREATE TABLE `ospos_item_quantities` (
  `item_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quantity` decimal(15,3) NOT NULL DEFAULT '0.000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_item_quantities`
--

INSERT INTO `ospos_item_quantities` (`item_id`, `location_id`, `quantity`) VALUES
(1, 1, '0.000'),
(1, 2, '567963.000'),
(1, 3, '2971.000'),
(1, 4, '0.000'),
(1, 5, '0.000'),
(1, 6, '0.000'),
(1, 7, '0.000'),
(1, 8, '10.000'),
(1, 9, '0.000'),
(2, 1, '0.000'),
(2, 2, '134.000'),
(2, 3, '2990.000'),
(2, 4, '0.000'),
(2, 5, '0.000'),
(2, 6, '4.000'),
(2, 7, '0.000'),
(2, 8, '10.000'),
(2, 9, '0.000'),
(3, 1, '0.000'),
(3, 2, '14.000'),
(3, 3, '0.000'),
(3, 4, '0.000'),
(3, 5, '0.000'),
(3, 6, '-2.000'),
(3, 7, '0.000'),
(3, 8, '0.000'),
(3, 9, '0.000'),
(4, 1, '0.000'),
(4, 2, '85.000'),
(4, 3, '4030.000'),
(4, 4, '0.000'),
(4, 5, '0.000'),
(4, 6, '-11.000'),
(4, 7, '0.000'),
(4, 8, '0.000'),
(4, 9, '0.000'),
(5, 1, '0.000'),
(5, 2, '0.000'),
(5, 3, '2975.000'),
(5, 4, '0.000'),
(5, 5, '0.000'),
(5, 6, '0.000'),
(5, 7, '0.000'),
(5, 8, '10.000'),
(5, 9, '0.000'),
(6, 2, '0.000'),
(6, 3, '2700.000'),
(6, 4, '0.000'),
(6, 5, '100.000'),
(6, 6, '200.000'),
(6, 8, '0.000'),
(10, 2, '130.000'),
(10, 3, '21.000'),
(10, 4, '0.000'),
(10, 5, '0.000'),
(10, 6, '2.000'),
(10, 8, '6.000'),
(11, 2, '0.000'),
(11, 3, '0.000'),
(11, 4, '0.000'),
(11, 5, '0.000'),
(11, 6, '0.000'),
(11, 8, '0.000'),
(12, 2, '2.000'),
(12, 3, '0.000'),
(12, 4, '0.000'),
(12, 5, '0.000'),
(12, 6, '10.000'),
(12, 8, '0.000'),
(13, 2, '15.000'),
(13, 3, '-1.000'),
(13, 4, '0.000'),
(13, 5, '8.000'),
(13, 6, '11.000'),
(13, 8, '0.000'),
(14, 2, '6.000'),
(14, 3, '0.000'),
(14, 4, '0.000'),
(14, 5, '0.000'),
(14, 6, '5.000'),
(14, 8, '6.000'),
(15, 2, '14.000'),
(15, 3, '0.000'),
(15, 4, '0.000'),
(15, 5, '0.000'),
(15, 6, '6.000'),
(15, 8, '0.000'),
(16, 2, '15.000'),
(16, 3, '0.000'),
(16, 4, '0.000'),
(16, 5, '0.000'),
(16, 6, '6.000'),
(16, 8, '0.000'),
(17, 2, '9.000'),
(17, 3, '0.000'),
(17, 4, '0.000'),
(17, 5, '0.000'),
(17, 6, '16.000'),
(17, 8, '0.000'),
(18, 2, '12.000'),
(18, 3, '0.000'),
(18, 4, '0.000'),
(18, 5, '0.000'),
(18, 6, '19.000'),
(18, 8, '0.000'),
(19, 2, '0.000'),
(19, 3, '10.000'),
(19, 4, '0.000'),
(19, 5, '7.000'),
(19, 6, '9.000'),
(19, 8, '0.000'),
(20, 2, '5.000'),
(20, 3, '0.000'),
(20, 4, '0.000'),
(20, 5, '-1.000'),
(20, 6, '3.000'),
(20, 8, '0.000');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_modules`
--

CREATE TABLE `ospos_modules` (
  `name_lang_key` varchar(255) NOT NULL,
  `desc_lang_key` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `module_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_modules`
--

INSERT INTO `ospos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`) VALUES
('module_accounts', 'module_accounts_desc', 73, 'accounts'),
('module_auditingtrail', 'module_auditingtrail_desc', 200, 'auditingtrail'),
('module_config', 'module_config_desc', 110, 'config'),
('module_customers', 'module_customers_desc', 10, 'customers'),
('module_employees', 'module_employees_desc', 80, 'employees'),
('module_giftcards', 'module_giftcards_desc', 90, 'giftcards'),
('module_grn', 'module_grn_desc', 56, 'grn'),
('module_inventories', 'module_inventories_desc', 25, 'inventories'),
('module_invoice', 'module_invoice_desc', 75, 'invoice'),
('module_items', 'module_items_desc', 20, 'items'),
('module_messages', 'module_messages_desc', 100, 'messages'),
('module_pay', 'module_pay_desc', 71, 'pay'),
('module_purchase_order', 'module_purchase_order_desc', 55, 'purchase_order'),
('module_reports', 'module_reports_desc', 72, 'reports'),
('module_requisition', 'module_requisition_desc', 62, 'requisition'),
('module_return_desc', 'module_return_desc', 58, 'return'),
('module_sales', 'module_sales_desc', 20, 'sales'),
('module_stockorder_check', 'module_stockorder_check_desc', 63, 'stockorder_check'),
('module_stock_order_desc', 'module_stock_order_desc', 61, 'stock_order'),
('module_suppliers', 'module_suppliers_desc', 40, 'suppliers'),
('module_taxes', 'module_taxes_desc', 105, 'taxes');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_people`
--

CREATE TABLE `ospos_people` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` int(1) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `person_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_people`
--

INSERT INTO `ospos_people` (`first_name`, `last_name`, `gender`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `person_id`) VALUES
('Super', 'Admin', 1, '555-555-5555', 'admin@sokxay.com', 'Address 1', '', '', '', '', '', '', 1),
('John', 'Deo', 1, '5475475757', '', '5022 Cannan Center Road', '', 'San Antonio', 'Texas', '78256', 'United States of America', '', 2),
('Smith', 'Joe', 1, '965735534', 'smithjoe@gmail.com', '65 pine street', '', 'Portlander', 'Oregon', '97209', 'United States of Americaer', '', 3),
('Waredell ', 'Dave', 1, '7974456434', 'waredell@gmail.com', '444 Big road', '', 'Big', 'Nevada', 'undefined', 'United States of America', '', 4),
('Robbins', 'Marry', 1, '6586855454', 'robins@gmail.com', '322 Sandhil Lane', '', 'San Diego', 'California', '92101', 'United States of America', '', 5),
('Drummond', 'Lake', 1, '8675654554', 'drummond@gmail.com', '325 N Saint Paul Street', '', 'Andover', 'Massachusetts', '01810', 'United States of America', '', 6),
('James', 'Byun', 1, '8989889786', 'jamesbyun@gmail.com', '', '', 'San Marcos', 'California', '92078', 'United States of America', '', 7),
('Jennifer', 'Gerth', 0, '985534233', 'jenifer@gmail.com', '8063, Facilisi Road', '', 'Humboldt Mine', 'Michigan', '49814', 'United States of America', '', 8),
('Susan', 'Gibbons', 0, '778656654', 'susan@gmail.com', '5967 Santonia Road', '', 'undefined', 'California', 'undefined', 'United States of America', '', 9),
('Lawarence', 'Chan', 1, '96767666', 'lawarance@gmail.com', '8405, Imperdiet Avenue', '', 'Poe', 'Ohio', '977878', 'United States of America', '', 10),
('Kel', 'Alders', 1, '96767566', 'kelalders@gmail.com', '977, North Highway Road', '', 'Fairhill', 'South Carolina', '29170', 'United States of America', '', 11),
('Jerry', 'Paton', 1, '965657575', 'jerrypaton@gmail.com', '76, South Usman Road', '', 'San Francisco', 'California', '94117', 'United States of America', '', 12),
('Lance', 'Regal', 0, '897768685', 'lanceregal@gmail.com', '76, Gandhi Nagar', '', 'Portland', 'Oregon', '97239', 'United States of America', '', 13),
('Mark', 'Richardson', 1, '747454563', 'markrichard@gmail.com', '43, West Mount Road', '', 'Wes', 'Oklahoma', '87856', 'United States of America', '', 14),
('Carl', 'Peters', 1, '878965564', 'carl@gmail.com', '675, Mount Road', '', 'Bluffton', 'Missouri', 'MO', 'United States of America', '', 15),
('', '', 0, '', '', '', '', '', '', '', '', '', 16),
('', '', NULL, '', '', '', '', '', '', '', '', '', 17),
('', '', NULL, '', '', '', '', '', '', '', '', '', 18),
('', '', NULL, '', '', '', '', '', '', '', '', '', 19),
('Alex', 'Philips', 0, '1234567890', 'ramalakshmi.a@mookambikainfo.com', '12, test address', '12, test address', 'madurai', 'TN', '938039', 'India', '!3.6. 2017 comments', 20),
('', '', NULL, '', '', '', '', '', '', '', '', '', 21),
('Tee', 'Tee', NULL, '', '', '', '', '', '', '', '', '', 22),
('Fdfsd', '', NULL, '', '', '', '', '', '', '', '', '', 23),
('213', '2321', NULL, 'sdaewqeqw', 'csvds', '', '', '', '', '', '', '', 24),
('', '', NULL, '', '', '', '', '', '', '', '', '', 25),
('Testt', 'Test', 0, '1234567890', 'ramalakshmi.a@mookambikainfo.com', '12, test address', '12, test address', 'madurai', 'TN', '938039', 'India', 'ewrewr', 26),
('', '6', 0, '##0_);[Red]\\("$"#', '##0\\)="$"#', '##0\\)?"$"#', '##0.00_);\\("$"#', '##0.00\\)I""$"#', '##0.00_);[Red]\\("$"#', '##0.00\\)i*2_("$"* #', '##0_);_("$"* \\(#', '##0\\);_("$"* "-"_);_(@_)W))_(* #', 27),
('Asset NameAsset ModelYear of ManufacturingWarranty DurationDescription\rSpareparts IDSpare PartsSeverityQuantity Life SpanLife Span Period\rSerial NumberBarCodeTrace Year Of ManufacturingStand & Co.oop MDUSweeperTesting Spare parts3-Years', ' helps to utilise the hopper to maximum capacity', 0, ' Horizontal dust panel filter', ' controls forward and reverse direction', ' Vacuum cut-off for wet', ' sweeping', ' Electric dust filter shaker', ' Adjustable seat', ' Adjustable flap to pick large debris', ' Adjustable main and side brushes', ' Dual hoppers', 28),
('Bob', 'Smith', 1, '585-555-1111', 'bsmith@nowhere.com', '123 Nowhere Street', 'Apt 4', 'Awesome', 'NY', '11111', 'USA', 'Awesome guy', 29),
('test', 'test', 1, '4234324324', 'test@gmail.com', '123 Nowhere Street', 'Apt 4', 'Awesome', 'NY', '11111', 'USA', 'Awesome guy', 30),
('Hone', 'dfsdf', 1, '32432434', 'test1@gmail.com', '123 Nowhere Street', 'Apt 4', 'Awesome', 'NY', '33432432', 'USA', 'Goos', 31),
('test', 'test', 1, '4234324324', 'test@gmail.com', '123 Nowhere Street', 'Apt 4', 'Awesome', 'NY', '11111', 'USA', 'Awesome guy', 32),
('Hone', 'Dfsdf#!&*()_@#@!^&)+)^#', 1, '32432434', 'test$1@gmail.com', '123 Nowhere Street', 'Apt 4', 'Awesome', 'NY', '33432432', 'USA', 'Goos', 33),
('Test', 'Test', 1, '34234324', 'ramalakshmi.a@mookambikainfo.com', '12, test address', '12, test address', 'theni', 'TN', '938039', 'India', '', 34),
('Rt', 'Ret', 0, '1234567890', 'ramalakshmi.a@mookambikainfo.com', '12, test address', '12, test address', 'madurai', 'TN', '938039', 'India', '', 35),
('', '', NULL, '', '', '', '', '', '', '', '', '', 36),
('Testt', 'Test', 1, '1234567890', 'ramalakshmi.a@mookambikainfo.com', '12, test address', '12, test address', 'te', 'tet', 'etse', 'tetew', 'wetwe', 55);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_permissions`
--

CREATE TABLE `ospos_permissions` (
  `permission_id` varchar(255) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  `location_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_permissions`
--

INSERT INTO `ospos_permissions` (`permission_id`, `module_id`, `location_id`) VALUES
('accounts', 'accounts', NULL),
('auditingtrail', 'auditingtrail', NULL),
('config', 'config', NULL),
('customers', 'customers', NULL),
('employees', 'employees', NULL),
('giftcards', 'giftcards', NULL),
('grn', 'grn', NULL),
('grn_Warehouse ', 'grn', 2),
('grn_Warehouse2', 'grn', 3),
('inventories', 'inventories', NULL),
('inventories_Alwa Store', 'inventories', 6),
('inventories_Anand Store', 'inventories', 8),
('inventories_Nellai Store', 'inventories', 5),
('inventories_Sivaksi Store', 'inventories', 4),
('inventories_Warehouse ', 'inventories', 2),
('inventories_Warehouse2', 'inventories', 3),
('invoice', 'invoice', NULL),
('invoice_Alwa Store', 'invoice', 6),
('invoice_Anand Store', 'invoice', 8),
('invoice_Nellai Store', 'invoice', 5),
('invoice_Sivaksi Store', 'invoice', 4),
('items', 'items', NULL),
('items_Alwa Store', 'items', 6),
('items_Anand Store', 'items', 8),
('items_Nellai Store', 'items', 5),
('items_Sivaksi Store', 'items', 4),
('items_Warehouse ', 'items', 2),
('items_Warehouse2', 'items', 3),
('messages', 'messages', NULL),
('pay', 'pay', NULL),
('pay_Warehouse ', 'pay', 2),
('pay_Warehouse2', 'pay', 3),
('purchase_order', 'purchase_order', NULL),
('purchase_order_Warehouse ', 'purchase_order', 2),
('purchase_order_Warehouse2', 'purchase_order', 3),
('reports', 'reports', NULL),
('reports_categories', 'reports', NULL),
('reports_customers', 'reports', NULL),
('reports_discounts', 'reports', NULL),
('reports_employees', 'reports', NULL),
('reports_inventory', 'reports', NULL),
('reports_items', 'reports', NULL),
('reports_payments', 'reports', NULL),
('reports_receivings', 'reports', NULL),
('reports_sales', 'reports', NULL),
('reports_suppliers', 'reports', NULL),
('reports_taxes', 'reports', NULL),
('requisition', 'requisition', NULL),
('requisition_Warehouse ', 'requisition', 2),
('requisition_Warehouse2', 'requisition', 3),
('return', 'return', NULL),
('return_Alwa Store', 'return', 6),
('return_Anand Store', 'return', 8),
('return_Nellai Store', 'return', 5),
('return_Sivaksi Store', 'return', 4),
('return_Warehouse ', 'return', 2),
('return_Warehouse2', 'return', 3),
('sales', 'sales', NULL),
('sales_Alwa Store', 'sales', 6),
('sales_Anand Store', 'sales', 8),
('sales_Nellai Store', 'sales', 5),
('sales_Sivaksi Store', 'sales', 4),
('stockorder_check', 'stockorder_check', NULL),
('stockorder_check_Alwa Store', 'stockorder_check', 6),
('stockorder_check_Anand Store', 'stockorder_check', 8),
('stockorder_check_Nellai Store', 'stockorder_check', 5),
('stockorder_check_Sivaksi Store', 'stockorder_check', 4),
('stock_order', 'stock_order', NULL),
('stock_order_Alwa Store', 'stock_order', 6),
('stock_order_Anand Store', 'stock_order', 8),
('stock_order_Nellai Store', 'stock_order', 5),
('stock_order_Sivaksi Store', 'stock_order', 4),
('suppliers', 'suppliers', NULL),
('taxes', 'taxes', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_receivings`
--

CREATE TABLE `ospos_receivings` (
  `receiving_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `receiving_id` int(10) NOT NULL,
  `receiving_ref` varchar(15) NOT NULL,
  `receiving_mode` enum('po','receive','return','requisition','stock_return','stock_order','stockorder_check') NOT NULL DEFAULT 'receive',
  `po_ref` int(10) NOT NULL,
  `receiving_status` enum('draft','open','partially','closed','void') NOT NULL DEFAULT 'draft',
  `payment_type` varchar(20) DEFAULT NULL,
  `payment_status` enum('','unpaid','paid','partially') NOT NULL DEFAULT '',
  `payment_ref` varchar(10) NOT NULL,
  `reference` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_receivings`
--

INSERT INTO `ospos_receivings` (`receiving_time`, `supplier_id`, `employee_id`, `comment`, `receiving_id`, `receiving_ref`, `receiving_mode`, `po_ref`, `receiving_status`, `payment_type`, `payment_status`, `payment_ref`, `reference`) VALUES
('2017-05-30 14:20:51', 13, 7, '', 1, 'PO 0001', 'po', 0, 'closed', NULL, '', '', ''),
('2017-05-30 14:21:48', 13, 7, '', 2, 'GRN 0001', 'receive', 1, 'closed', 'Cash', 'paid', 'BILL 0001', NULL),
('2017-05-30 14:25:48', 13, 7, '', 3, 'GRN 0002', 'receive', 1, 'closed', 'Cash', 'paid', 'BILL 0002', NULL),
('2017-05-30 14:26:03', 13, 7, '', 4, 'GRN 0003', 'receive', 1, 'closed', 'Cash', 'paid', 'BILL 0003', NULL),
('2017-05-30 14:31:23', 3, 10, '', 5, 'SO 0001', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-05-30 14:32:00', 3, 7, '', 6, 'REQ 0001', 'requisition', 5, 'closed', NULL, '', '', NULL),
('2017-05-30 14:34:13', 3, 10, '', 7, 'SOC 0001', 'stockorder_check', 6, 'closed', NULL, '', '', NULL),
('2017-05-30 14:36:04', 3, 10, '', 8, 'SO 0002', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-05-30 14:36:29', 3, 7, '', 9, 'REQ 0002', 'requisition', 8, 'closed', NULL, '', '', NULL),
('2017-05-30 14:36:49', 3, 1, '', 10, 'SOC 0002', 'stockorder_check', 9, 'closed', NULL, '', '', NULL),
('2017-05-30 14:38:46', 15, 7, '', 11, 'PO 0002', 'po', 0, 'closed', NULL, '', '', ''),
('2017-05-30 14:49:24', 15, 7, '', 12, 'GRN 0004', 'receive', 11, 'closed', 'Cash', 'paid', 'BILL 0004', NULL),
('2017-06-01 13:42:29', 13, 1, '', 13, 'PO 0003', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-01 13:43:55', 13, 1, '', 14, 'GRN 0005', 'receive', 13, 'closed', 'Cash', 'paid', 'BILL 0005', NULL),
('2017-06-01 14:02:30', 13, 1, '', 15, 'PO 0004', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-01 14:02:51', 13, 1, 'Testing', 16, 'GRN 0006', 'receive', 15, 'closed', 'Cash', 'paid', 'BILL 0006', NULL),
('2017-06-05 12:10:01', 13, 1, '', 17, 'PO 0005', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-05 12:10:11', 13, 1, '', 18, 'GRN 0007', 'receive', 17, 'closed', 'Cash', 'paid', 'BILL 0007', NULL),
('2017-06-05 12:28:39', 13, 1, '', 19, 'PO 0006', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-06 14:52:07', 13, 1, '', 20, 'GRN 0008', 'receive', 19, 'closed', 'Cash', 'paid', 'BILL 0008', NULL),
('2017-06-12 11:09:26', 13, 1, '', 21, 'PO 0007', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-12 13:02:28', 15, 1, '', 22, 'PO 0008', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-12 13:02:59', 14, 1, '', 23, 'PO 0009', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-12 13:04:09', 14, 1, '', 24, 'PO 0010', 'po', 0, 'draft', NULL, '', '', ''),
('2017-06-12 13:04:58', 13, 1, '', 25, 'GRN 0009', 'receive', 21, 'draft', NULL, '', '', NULL),
('2017-06-12 13:06:31', 11, 1, '', 26, 'PO 0011', 'po', 0, 'draft', NULL, '', '', ''),
('2017-06-12 13:07:17', 11, 1, '', 27, 'PO 0012', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-12 13:09:19', 15, 1, '', 28, 'GRN 0010', 'receive', 22, 'void', NULL, '', '', NULL),
('2017-06-12 13:11:28', 3, 1, '', 29, 'SO 0003', 'stock_order', 0, 'open', NULL, '', '', ''),
('2017-06-12 13:11:53', 3, 1, '', 30, 'SO 0004', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-12 13:13:07', 3, 1, '', 31, 'SO 0005', 'stock_order', 0, 'draft', NULL, '', '', ''),
('2017-06-12 13:18:04', 3, 1, '', 32, 'SO 0006', 'stock_order', 0, 'draft', NULL, '', '', ''),
('2017-06-12 13:18:35', 2, 1, 'TEST 1234', 33, 'SO 0007', 'stock_order', 0, 'draft', NULL, '', '', ''),
('2017-06-12 14:30:54', 11, 1, 'test po 12.6.\n', 34, 'PO 0013', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-12 14:34:12', 14, 1, 'PO to supplier ', 35, 'PO 0014', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-12 14:37:05', 14, 1, 'WE will check it and give the upate', 36, 'GRN 0011', 'receive', 35, 'draft', NULL, '', '', NULL),
('2017-06-12 14:42:21', 14, 1, 'test', 37, 'GRN 0012', 'receive', 23, 'draft', NULL, '', '', NULL),
('2017-06-12 14:50:07', 14, 1, '', 38, 'GRN 0013', 'receive', 23, 'closed', NULL, 'unpaid', 'BILL 0027', NULL),
('2017-06-12 14:51:01', 14, 1, '', 39, 'PO 0015', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-12 14:52:05', 14, 1, '', 40, 'GRN 0014', 'receive', 39, 'void', NULL, '', '', NULL),
('2017-06-12 14:52:41', 14, 1, '', 41, 'GRN 0015', 'receive', 39, 'draft', NULL, '', '', NULL),
('2017-06-12 14:53:40', 2, 1, '', 42, 'SO 0008', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-12 14:54:09', 2, 1, '', 43, 'SO 0009', 'stock_order', 0, 'draft', NULL, '', '', ''),
('2017-06-12 14:58:02', 2, 1, '', 44, 'SO 0010', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-12 14:58:13', 2, 1, '', 45, 'REQ 0003', 'requisition', 44, 'open', NULL, '', '', NULL),
('2017-06-12 15:27:54', 15, 1, '', 46, 'PO 0016', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-12 15:29:22', 15, 1, '25 only received', 47, 'GRN 0016', 'receive', 46, 'void', NULL, '', '', NULL),
('2017-06-12 15:30:24', 15, 1, '23 only got it', 48, 'GRN 0017', 'receive', 46, 'closed', 'Cash', 'partially', 'BILL 0017', NULL),
('2017-06-12 15:30:57', 15, 1, '', 49, 'GRN 0018', 'receive', 46, 'closed', 'Cash', 'partially', 'BILL 0009', NULL),
('2017-06-12 15:35:51', 3, 1, '20 ', 50, 'SO 0011', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-12 15:36:42', 3, 1, '15 ', 51, 'REQ 0004', 'requisition', 50, 'open', NULL, '', '', NULL),
('2017-06-12 15:38:35', 3, 1, '20', 52, 'REQ 0005', 'requisition', 30, 'open', NULL, '', '', NULL),
('2017-06-14 06:11:29', 14, 1, 'nos "100 ', 53, 'PO 0017', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-14 06:16:24', 14, 1, '50 quantiy only received', 54, 'GRN 0019', 'receive', 53, 'closed', 'Cash', 'paid', 'BILL 0010', NULL),
('2017-06-14 06:33:32', 14, 1, 'Totally 100 received', 55, 'GRN 0020', 'receive', 53, 'closed', 'Debit Card', 'paid', 'BILL 0011', NULL),
('2017-06-14 13:01:57', NULL, 1, '', 56, 'PO 0018', 'po', 0, 'draft', NULL, '', '', ''),
('2017-06-14 14:54:03', 11, 55, 'test GRN', 57, 'GRN 0021', 'receive', 34, 'closed', NULL, 'unpaid', 'BILL 0013', NULL),
('2017-06-14 14:54:35', 11, 55, 'test23', 58, 'GRN 0022', 'receive', 34, 'closed', 'Cash', 'paid', 'BILL 0012', NULL),
('2017-06-15 11:20:17', 12, 1, '25 Pen Needed ', 59, 'PO 0019', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-15 11:24:41', 12, 1, '20 only received', 60, 'GRN 0023', 'receive', 59, 'closed', 'Cash', 'paid', 'BILL 0014', NULL),
('2017-06-15 12:05:21', 12, 1, '', 61, 'PO 0020', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-15 12:05:59', 12, 1, 'finished', 62, 'GRN 0024', 'receive', 59, 'closed', 'Cash', 'paid', 'BILL 0015', NULL),
('2017-06-15 14:46:20', 11, 1, 'f', 63, 'GRN 0025', 'receive', 27, 'closed', 'Cash', 'paid', 'BILL 0016', NULL),
('2017-06-16 07:46:26', 15, 1, '', 64, 'PO 0021', 'po', 0, 'draft', NULL, '', '', ''),
('2017-06-16 07:57:42', 15, 1, 'Some comments updated by Admin', 65, 'PO 0022', 'po', 0, 'open', NULL, '', '', ''),
('2017-06-16 08:13:47', 11, 1, '10 recived 10 bal\n', 66, 'GRN 0026', 'receive', 27, 'closed', NULL, 'unpaid', 'BILL 0018', NULL),
('2017-06-16 09:12:06', NULL, 1, '', 67, 'PO 0023', 'po', 0, 'open', NULL, '', '', ''),
('2017-06-16 09:25:23', 13, 1, 'rtet', 68, 'PO 0024', 'po', 0, 'open', NULL, '', '', ''),
('2017-06-16 09:34:15', 14, 55, 'warehouse sent to supplier', 69, 'PO 0025', 'po', 0, 'open', NULL, '', '', ''),
('2017-06-16 09:35:24', 12, 55, 'tsetset', 70, 'PO 0026', 'po', 0, 'draft', NULL, '', '', ''),
('2017-06-16 11:34:25', 11, 1, '', 71, 'PO 0027', 'po', 0, 'open', NULL, '', '', ''),
('2017-06-16 12:10:54', 11, 1, 'test', 72, 'PO 0028', 'po', 0, 'open', NULL, '', '', ''),
('2017-06-16 14:54:25', 11, 1, 'ret', 73, 'PO 0029', 'po', 0, 'open', NULL, '', '', ''),
('2017-06-19 07:35:00', 12, 1, '1 Out of 5 "', 74, 'PO 0030', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-19 08:01:02', NULL, 1, '', 75, 'PO 0031', 'po', 0, 'draft', NULL, '', '', ''),
('2017-06-19 08:25:05', 12, 1, 'test 3 Quanity', 76, 'PO 0032', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-19 09:00:18', 12, 1, '', 77, 'GRN 0027', 'receive', 74, 'closed', 'Cash', 'paid', 'BILL 0019', NULL),
('2017-06-19 09:03:47', 12, 1, '', 78, 'GRN 0028', 'receive', 76, 'closed', 'Cash', 'paid', 'BILL 0026', NULL),
('2017-06-19 12:34:28', 12, 1, '32 Completed', 79, 'GRN 0029', 'receive', 76, 'closed', 'Cash', 'paid', 'BILL 0024', NULL),
('2017-06-19 14:09:38', 12, 1, 'test', 80, 'PO 0033', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-19 14:10:13', 12, 1, 'test2', 81, 'GRN 0030', 'receive', 80, 'closed', 'Cash', 'paid', 'BILL 0023', NULL),
('2017-06-19 14:26:45', 13, 1, '4 out of 7', 82, 'PO 0034', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-19 14:28:21', 13, 1, '1350 rs 3 quantiyt', 83, 'GRN 0031', 'receive', 82, 'closed', 'Credit Card', 'paid', 'BILL 0020', NULL),
('2017-06-19 14:29:51', 13, 1, 'Closed', 84, 'GRN 0032', 'receive', 82, 'closed', 'Check', 'paid', 'BILL 0021', NULL),
('2017-06-20 06:41:23', 15, 1, 'Po generated to Carl', 85, 'PO 0035', 'po', 0, 'open', NULL, '', '', ''),
('2017-06-20 12:07:47', 12, 1, 'terewrew', 86, 'GRN 0033', 'receive', 61, 'closed', 'Cash', 'paid', 'BILL 0022', NULL),
('2017-06-20 12:14:30', 11, 1, '4', 87, 'PO 0036', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-20 12:15:09', 11, 1, '4 received', 88, 'GRN 0034', 'receive', 87, 'closed', 'Cash', 'paid', 'BILL 0025', NULL),
('2017-06-20 15:14:29', 2, 1, 'j', 89, 'REQ 0006', 'requisition', 42, 'open', NULL, '', '', NULL),
('2017-06-21 06:42:40', 3, 1, '3 needed', 90, 'SO 0012', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-21 06:45:36', 3, 1, 'received', 91, 'REQ 0007', 'requisition', 90, 'closed', NULL, '', '', NULL),
('2017-06-21 06:47:32', 3, 1, 'successfuull', 92, 'SOC 0003', 'stockorder_check', 91, 'closed', NULL, '', '', NULL),
('2017-06-21 06:49:58', 2, 1, 're', 93, 'SO 0013', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-21 06:50:25', 2, 1, 'dewrewr', 94, 'REQ 0008', 'requisition', 93, 'closed', NULL, '', '', NULL),
('2017-06-21 06:50:41', 2, 1, 'ewrewr', 95, 'SOC 0004', 'stockorder_check', 94, 'closed', NULL, '', '', NULL),
('2017-06-21 07:13:08', 2, 1, 'erewr', 96, 'SO 0014', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-21 07:13:24', 2, 1, 'erewr', 97, 'REQ 0009', 'requisition', 96, 'closed', NULL, '', '', NULL),
('2017-06-21 07:14:32', 2, 1, 'dfwr', 98, 'SOC 0005', 'stockorder_check', 97, 'closed', NULL, '', '', NULL),
('2017-06-21 07:17:25', 2, 1, '4ertret', 99, 'SO 0015', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-21 07:18:02', 2, 1, '4 recived', 100, 'REQ 0010', 'requisition', 99, 'closed', NULL, '', '', NULL),
('2017-06-21 07:18:41', 2, 1, 'drewr', 101, 'SOC 0006', 'stockorder_check', 100, 'closed', NULL, '', '', NULL),
('2017-06-21 07:58:19', 2, 1, 'trtet', 102, 'SO 0016', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-21 07:58:30', 2, 1, 'fdgd', 103, 'SO 0017', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-21 07:59:00', 2, 1, 'tret', 104, 'REQ 0011', 'requisition', 103, 'closed', NULL, '', '', NULL),
('2017-06-21 07:59:31', 2, 1, 'retret', 105, 'SOC 0007', 'stockorder_check', 104, 'closed', NULL, '', '', NULL),
('2017-06-21 08:12:55', 2, 1, 'ewrwer', 106, 'SO 0018', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-21 08:13:30', 12, 1, 'ewrew', 107, 'PO 0037', 'po', 0, 'closed', NULL, '', '', ''),
('2017-06-21 08:14:27', 12, 1, 'ewwe', 108, 'GRN 0035', 'receive', 107, 'closed', 'Debit Card', 'paid', 'BILL 0028', NULL),
('2017-06-21 08:18:10', 2, 1, '', 109, 'SO 0019', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-21 08:19:09', 2, 1, 'ssdf', 110, 'SO 0020', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-21 08:20:22', 2, 1, 'drewr', 111, 'REQ 0012', 'requisition', 110, 'closed', NULL, '', '', NULL),
('2017-06-21 08:20:58', 2, 1, 'sdsdfdsf', 112, 'SOC 0008', 'stockorder_check', 111, 'closed', NULL, '', '', NULL),
('2017-06-23 08:47:36', 2, 10, 'Watch 3 Quantity', 113, 'SO 0021', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-23 09:01:31', 3, 1, 'selfie', 114, 'SO 0022', 'stock_order', 0, 'open', NULL, '', '', ''),
('2017-06-23 09:30:32', 2, 10, 'test setlft10', 115, 'SO 0023', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-23 11:46:32', 3, 1, 'test watch1 sopen ', 116, 'SO 0024', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-23 12:17:34', 3, 1, 'test', 117, 'SO 0025', 'stock_order', 0, 'open', NULL, '', '', ''),
('2017-06-23 12:59:58', 3, 1, 'treter', 118, 'REQ 0013', 'requisition', 116, 'open', NULL, '', '', NULL),
('2017-06-23 13:01:11', 2, 1, 'etewtew', 119, 'REQ 0014', 'requisition', 115, 'open', NULL, '', '', NULL),
('2017-06-23 13:17:29', 2, 1, 'test', 120, 'SO 0026', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-23 13:18:10', 2, 1, 'test', 121, 'REQ 0015', 'requisition', 120, 'closed', NULL, '', '', NULL),
('2017-06-23 13:19:01', 2, 1, 'test4', 122, 'SOC 0009', 'stockorder_check', 121, 'closed', NULL, '', '', NULL),
('2017-06-23 14:21:47', 3, 1, '', 123, 'SO 0027', 'stock_order', 0, 'open', NULL, '', '', ''),
('2017-06-23 15:29:14', 2, 1, 'fffff', 124, 'REQ 0016', 'requisition', 113, 'open', NULL, '', '', NULL),
('2017-06-24 06:21:29', 2, 1, 'f', 125, 'REQ 0017', 'requisition', 109, 'open', NULL, '', '', NULL),
('2017-06-24 06:30:26', 2, 1, 'test', 126, 'REQ 0018', 'requisition', 102, 'closed', NULL, '', '', NULL),
('2017-06-24 06:31:22', 2, 1, 'test', 127, 'SOC 0010', 'stockorder_check', 126, 'closed', NULL, '', '', NULL),
('2017-06-24 06:33:03', 2, 1, 'test', 128, 'REQ 0019', 'requisition', 106, 'closed', NULL, '', '', NULL),
('2017-06-24 06:33:36', 2, 1, 'test', 129, 'SOC 0011', 'stockorder_check', 128, 'closed', NULL, '', '', NULL),
('2017-06-24 06:36:48', 3, 1, '200', 130, 'SO 0028', 'stock_order', 0, 'closed', NULL, '', '', ''),
('2017-06-24 06:41:57', 3, 1, '200', 131, 'REQ 0020', 'requisition', 130, 'closed', NULL, '', '', NULL),
('2017-06-24 09:03:48', 3, 1, 'test', 132, 'SOC 0012', 'stockorder_check', 131, 'closed', NULL, '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_receivings_items`
--

CREATE TABLE `ospos_receivings_items` (
  `receiving_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` decimal(15,3) NOT NULL DEFAULT '0.000',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `discount_percent` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_location` int(11) NOT NULL,
  `request_quantity` decimal(15,3) NOT NULL,
  `balance_quantity` float(15,3) NOT NULL,
  `receiving_quantity` decimal(15,3) NOT NULL DEFAULT '1.000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_receivings_items`
--

INSERT INTO `ospos_receivings_items` (`receiving_id`, `item_id`, `description`, `serialnumber`, `line`, `quantity_purchased`, `item_cost_price`, `item_unit_price`, `discount_percent`, `item_location`, `request_quantity`, `balance_quantity`, `receiving_quantity`) VALUES
(1, 1, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(1, 2, NULL, NULL, 2, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(1, 4, NULL, NULL, 3, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(1, 5, NULL, NULL, 4, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(1, 6, NULL, NULL, 5, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(2, 1, '', NULL, 1, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '89.000'),
(2, 2, '', NULL, 2, '0.000', '11.00', '11.00', '0.00', 3, '0.000', 0.000, '54.000'),
(2, 4, '', NULL, 3, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '67.000'),
(2, 5, '', NULL, 4, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '435.000'),
(2, 6, '', NULL, 5, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '21.000'),
(3, 1, '', '', 1, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '911.000'),
(3, 2, '', NULL, 2, '0.000', '11.00', '11.00', '0.00', 3, '0.000', 0.000, '941.000'),
(3, 4, '', NULL, 3, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '931.000'),
(3, 5, '', NULL, 4, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '561.000'),
(3, 6, '', NULL, 5, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '971.000'),
(4, 1, '', '', 1, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '0.000'),
(4, 2, '', '', 2, '0.000', '11.00', '11.00', '0.00', 3, '0.000', 0.000, '5.000'),
(4, 4, '', '', 3, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '2.000'),
(4, 5, '', '', 4, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '4.000'),
(4, 6, '', '', 5, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '8.000'),
(5, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 8, '10.000', 0.000, '0.000'),
(5, 2, '', '', 2, '0.000', '10.00', '0.00', '0.00', 8, '10.000', 0.000, '0.000'),
(5, 5, '', '', 3, '0.000', '10.00', '0.00', '0.00', 8, '10.000', 0.000, '0.000'),
(6, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 8, '0.000', -10.000, '10.000'),
(6, 2, '', '', 2, '0.000', '10.00', '0.00', '0.00', 8, '0.000', -10.000, '10.000'),
(6, 5, '', '', 3, '0.000', '10.00', '0.00', '0.00', 8, '0.000', -10.000, '10.000'),
(7, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 8, '0.000', 0.000, '10.000'),
(7, 2, '', '', 2, '0.000', '10.00', '0.00', '0.00', 8, '0.000', 0.000, '10.000'),
(7, 5, '', '', 3, '0.000', '10.00', '0.00', '0.00', 8, '0.000', 0.000, '10.000'),
(8, 6, '', '', 1, '0.000', '10.00', '0.00', '0.00', 5, '100.000', 0.000, '0.000'),
(9, 6, '', '', 1, '0.000', '10.00', '0.00', '0.00', 5, '0.000', -100.000, '100.000'),
(10, 6, '', '', 1, '0.000', '10.00', '0.00', '0.00', 5, '0.000', 0.000, '100.000'),
(11, 4, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(12, 4, '', '', 1, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(13, 1, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(13, 2, NULL, '', 2, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(13, 4, NULL, '', 3, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(13, 5, NULL, '', 4, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(13, 6, NULL, '', 5, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(14, 1, '', '', 1, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(14, 2, '', '', 2, '0.000', '11.00', '11.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(14, 4, '', '', 3, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(14, 5, '', '', 4, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(14, 6, '', NULL, 5, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(15, 1, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(15, 2, NULL, '', 2, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(15, 4, NULL, '', 3, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(15, 5, NULL, '', 4, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(15, 6, NULL, '', 5, '0.000', '0.00', '0.00', '0.00', 3, '1000.000', 0.000, '0.000'),
(16, 1, '', '', 1, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(16, 2, '', '', 2, '0.000', '11.00', '11.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(16, 4, '', '', 3, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(16, 5, '', '', 4, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(16, 6, '', '', 5, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '1000.000'),
(17, 1, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '11.000', 0.000, '0.000'),
(17, 2, NULL, '', 2, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(17, 4, NULL, '', 3, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(18, 1, '', '', 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '11.000'),
(18, 2, '', '', 2, '0.000', '11.00', '11.00', '0.00', 2, '0.000', 0.000, '10.000'),
(18, 4, '', '', 3, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '10.000'),
(19, 1, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '11.000', 0.000, '0.000'),
(19, 2, NULL, '', 2, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(19, 4, NULL, '', 3, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(20, 1, '', '', 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '11.000'),
(20, 2, '', '', 2, '0.000', '11.00', '11.00', '0.00', 2, '0.000', 0.000, '10.000'),
(20, 4, '', '', 3, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '10.000'),
(21, 1, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '11.000', 0.000, '0.000'),
(21, 2, NULL, '', 2, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(21, 4, NULL, '', 3, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(22, 1, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(23, 1, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(24, 2, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 10.000, '0.000'),
(25, 1, '', '', 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '11.000'),
(25, 2, '', NULL, 2, '0.000', '11.00', '11.00', '0.00', 2, '0.000', 0.000, '10.000'),
(25, 4, '', '', 3, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '10.000'),
(26, 1, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 10.000, '0.000'),
(26, 2, NULL, '', 3, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 10.000, '0.000'),
(26, 4, NULL, '', 2, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 10.000, '0.000'),
(27, 1, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 8.000, '0.000'),
(27, 2, NULL, '', 2, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 8.000, '0.000'),
(27, 3, NULL, '', 4, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 8.000, '0.000'),
(27, 4, NULL, NULL, 3, '0.000', '0.00', '0.00', '0.00', 2, '20.000', 0.000, '0.000'),
(28, 1, '', '', 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '10.000'),
(29, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '34.000', 34.000, '0.000'),
(30, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '30.000', 10.000, '0.000'),
(31, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '10.000', 10.000, '0.000'),
(31, 2, '', '', 2, '0.000', '10.00', '0.00', '0.00', 4, '55.000', 55.000, '0.000'),
(32, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '10.000', 10.000, '0.000'),
(33, 4, '', '', 2, '0.000', '10.00', '0.00', '0.00', 4, '10.000', 10.000, '0.000'),
(33, 5, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '10.000', 10.000, '0.000'),
(34, 1, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(34, 2, NULL, '', 2, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(34, 3, NULL, '', 3, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 0.000, '0.000'),
(34, 4, NULL, '', 4, '0.000', '0.00', '0.00', '0.00', 2, '20.000', 0.000, '0.000'),
(35, 4, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '15.000', 0.000, '0.000'),
(36, 4, '', NULL, 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '15.000'),
(37, 1, '', NULL, 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '9.000'),
(38, 1, '', NULL, 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '1.000'),
(39, 1, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '400.000', 0.000, '0.000'),
(40, 1, '', NULL, 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '200.000'),
(41, 1, '', '', 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '200.000'),
(42, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '25.000', 0.000, '0.000'),
(43, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '10.000', 10.000, '0.000'),
(44, 1, '', '', 2, '0.000', '10.00', '0.00', '0.00', 4, '25.000', 0.000, '0.000'),
(44, 2, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '10.000', 8.000, '0.000'),
(45, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '0.000', 0.000, '25.000'),
(45, 2, '', '', 2, '0.000', '10.00', '0.00', '0.00', 4, '0.000', 0.000, '2.000'),
(46, 4, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 3, '30.000', 0.000, '0.000'),
(47, 4, '', NULL, 1, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '25.000'),
(48, 4, '', NULL, 1, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '2.000'),
(49, 4, '', NULL, 1, '0.000', '10.00', '10.00', '0.00', 3, '0.000', 0.000, '3.000'),
(50, 5, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '20.000', 5.000, '0.000'),
(51, 5, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '0.000', 0.000, '15.000'),
(52, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '0.000', 0.000, '20.000'),
(53, 2, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '100.000', 0.000, '0.000'),
(54, 2, '', NULL, 1, '0.000', '11.00', '11.00', '0.00', 2, '0.000', 0.000, '50.000'),
(55, 2, '', NULL, 1, '0.000', '11.00', '11.00', '0.00', 2, '0.000', 0.000, '50.000'),
(56, 4, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 3, '10.000', 10.000, '0.000'),
(57, 1, '', NULL, 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '10.000'),
(57, 2, '', '', 2, '0.000', '11.00', '11.00', '0.00', 2, '0.000', 0.000, '10.000'),
(57, 3, '', '', 3, '0.000', '12.00', '12.00', '0.00', 2, '0.000', 0.000, '10.000'),
(57, 4, '', NULL, 4, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '10.000'),
(58, 4, '', '', 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '10.000'),
(59, 10, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '25.000', 0.000, '0.000'),
(60, 10, 'Productname is \r\nPen ', NULL, 1, '0.000', '12.00', '12.00', '0.00', 2, '0.000', 0.000, '20.000'),
(61, 10, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '25.000', 0.000, '0.000'),
(62, 10, 'Productname is \r\nPen ', NULL, 1, '0.000', '12.00', '12.00', '0.00', 2, '0.000', 0.000, '5.000'),
(63, 1, '', NULL, 1, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '2.000'),
(63, 2, '', NULL, 2, '0.000', '11.00', '11.00', '0.00', 2, '0.000', 0.000, '2.000'),
(63, 3, '', NULL, 3, '0.000', '12.00', '12.00', '0.00', 2, '0.000', 0.000, '2.000'),
(63, 4, '', NULL, 4, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '10.000'),
(64, 10, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 3, '25.000', 25.000, '0.000'),
(65, 10, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 3, '25.000', 25.000, '0.000'),
(66, 4, '', NULL, 4, '0.000', '10.00', '10.00', '0.00', 2, '0.000', 0.000, '10.000'),
(67, 13, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 3, '1.000', 1.000, '0.000'),
(68, 2, NULL, '', 3, '0.000', '0.00', '0.00', '0.00', 3, '10.000', 10.000, '0.000'),
(68, 4, NULL, '', 2, '0.000', '0.00', '0.00', '0.00', 3, '10.000', 10.000, '0.000'),
(68, 10, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 3, '25.000', 25.000, '0.000'),
(69, 1, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 10.000, '0.000'),
(70, 3, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '10.000', 10.000, '0.000'),
(71, 2, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 3, '10.000', 10.000, '0.000'),
(72, 2, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 3, '12.000', 12.000, '0.000'),
(73, 2, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 3, '13.000', 13.000, '0.000'),
(74, 14, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '1.000', 0.000, '0.000'),
(75, 14, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '1.000', 1.000, '0.000'),
(76, 15, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '3.000', 0.000, '0.000'),
(77, 14, 'test description...test descri', '', 1, '0.000', '100.00', '100.00', '0.00', 2, '0.000', 0.000, '1.000'),
(78, 15, '', NULL, 1, '0.000', '25.00', '25.00', '0.00', 2, '0.000', 0.000, '2.000'),
(79, 15, '', NULL, 1, '0.000', '25.00', '25.00', '0.00', 2, '0.000', 0.000, '1.000'),
(80, 15, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '3.000', 1.000, '0.000'),
(81, 15, '', NULL, 1, '0.000', '25.00', '25.00', '0.00', 2, '0.000', 0.000, '2.000'),
(82, 16, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '4.000', 0.000, '0.000'),
(83, 16, 'test descr', NULL, 1, '0.000', '450.00', '450.00', '0.00', 2, '0.000', 0.000, '3.000'),
(84, 16, 'test descr', NULL, 1, '0.000', '450.00', '450.00', '0.00', 2, '0.000', 0.000, '1.000'),
(85, 16, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '2.000', 2.000, '0.000'),
(86, 10, 'Productname is Pen ', '', 1, '0.000', '12.00', '12.00', '0.00', 2, '0.000', 0.000, '25.000'),
(87, 16, NULL, NULL, 1, '0.000', '0.00', '0.00', '0.00', 2, '4.000', 0.000, '0.000'),
(88, 16, 'test descr', NULL, 1, '0.000', '450.00', '450.00', '0.00', 2, '0.000', 0.000, '4.000'),
(89, 1, '', '', 1, '0.000', '10.00', '0.00', '0.00', 4, '0.000', 0.000, '25.000'),
(90, 17, 'testersdfrerwer', '', 1, '0.000', '0.00', '0.00', '0.00', 6, '3.000', 0.000, '0.000'),
(91, 17, 'testersdfrerwer', '', 1, '0.000', '0.00', '0.00', '0.00', 6, '0.000', -3.000, '3.000'),
(92, 17, 'testersdfrerwer', '', 1, '0.000', '0.00', '0.00', '0.00', 6, '0.000', 0.000, '3.000'),
(93, 17, 'testersdfrerwer', '', 1, '0.000', '190.00', '0.00', '0.00', 6, '3.000', 0.000, '0.000'),
(94, 17, 'testersdfrerwer', '', 1, '0.000', '190.00', '0.00', '0.00', 6, '0.000', -3.000, '3.000'),
(95, 17, 'testersdfrerwer', '', 1, '0.000', '190.00', '0.00', '0.00', 6, '0.000', 0.000, '3.000'),
(96, 18, 'test', '', 1, '0.000', '115.00', '0.00', '0.00', 6, '4.000', 1.000, '0.000'),
(97, 18, 'test', '', 1, '0.000', '115.00', '0.00', '0.00', 6, '0.000', 0.000, '3.000'),
(98, 18, 'test', '', 1, '0.000', '115.00', '0.00', '0.00', 6, '0.000', 0.000, '1.000'),
(99, 18, 'test', '', 1, '0.000', '115.00', '0.00', '0.00', 6, '4.000', 0.000, '0.000'),
(100, 18, 'test', '', 1, '0.000', '115.00', '0.00', '0.00', 6, '0.000', -4.000, '4.000'),
(101, 18, 'test', '', 1, '0.000', '115.00', '0.00', '0.00', 6, '0.000', 0.000, '4.000'),
(102, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '4.000', 2.000, '0.000'),
(103, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '1.000', 0.000, '0.000'),
(104, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '0.000', -1.000, '1.000'),
(105, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '0.000', 0.000, '1.000'),
(106, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '3.000', 1.000, '0.000'),
(107, 13, NULL, '', 1, '0.000', '0.00', '0.00', '0.00', 2, '1.000', 0.000, '0.000'),
(108, 13, '', NULL, 1, '0.000', '1500.00', '1500.00', '0.00', 2, '0.000', 0.000, '1.000'),
(109, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '1.000', 0.000, '0.000'),
(110, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 5, '1.000', 0.000, '0.000'),
(111, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 5, '0.000', -1.000, '1.000'),
(112, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 5, '0.000', 0.000, '1.000'),
(113, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '3.000', 0.000, '0.000'),
(114, 12, 'Product name : Selfiestick', '', 2, '0.000', '0.00', '0.00', '0.00', 5, '10.000', 10.000, '0.000'),
(115, 12, 'Product name : Selfiestick', '', 1, '0.000', '105.00', '0.00', '0.00', 6, '10.000', 5.000, '0.000'),
(116, 13, '', '', 1, '0.000', '0.00', '0.00', '0.00', 5, '1.000', 0.000, '0.000'),
(117, 13, '', '', 1, '0.000', '0.00', '0.00', '0.00', 6, '1.000', 1.000, '0.000'),
(118, 13, '', '', 1, '0.000', '0.00', '0.00', '0.00', 5, '0.000', 0.000, '1.000'),
(119, 12, 'Product name : Selfiestick', '', 1, '0.000', '105.00', '0.00', '0.00', 6, '0.000', 0.000, '5.000'),
(120, 2, '', '', 1, '0.000', '10.00', '0.00', '0.00', 6, '6.000', 0.000, '0.000'),
(121, 2, '', '', 1, '0.000', '10.00', '0.00', '0.00', 6, '0.000', -4.000, '6.000'),
(122, 2, '', '', 1, '0.000', '10.00', '0.00', '0.00', 6, '0.000', 0.000, '4.000'),
(123, 2, '', '', 1, '0.000', '10.00', '0.00', '0.00', 6, '6.000', 6.000, '0.000'),
(124, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '0.000', 0.000, '3.000'),
(125, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '0.000', 0.000, '1.000'),
(126, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '0.000', 0.000, '2.000'),
(127, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '0.000', 0.000, '2.000'),
(128, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '0.000', -1.000, '2.000'),
(129, 13, '', '', 1, '0.000', '950.00', '0.00', '0.00', 6, '0.000', 0.000, '2.000'),
(130, 6, '', '', 1, '0.000', '10.00', '0.00', '0.00', 6, '200.000', 0.000, '0.000'),
(131, 6, '', '', 1, '0.000', '10.00', '0.00', '0.00', 6, '0.000', -200.000, '200.000'),
(132, 6, '', '', 1, '0.000', '10.00', '0.00', '0.00', 6, '0.000', 0.000, '200.000');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_recpayment_made`
--

CREATE TABLE `ospos_recpayment_made` (
  `id` int(11) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_reference` text NOT NULL,
  `payment_notes` text NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `amount` float(15,3) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_rate_id` int(11) NOT NULL,
  `currency_rate` float(15,10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_recpayment_made`
--

INSERT INTO `ospos_recpayment_made` (`id`, `payment_date`, `payment_reference`, `payment_notes`, `supplier_id`, `employee_id`, `amount`, `payment_type`, `currency_id`, `currency_rate_id`, `currency_rate`) VALUES
(1, '2017-05-24 18:30:00', '35345345', 'gdgfdgdfg', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(2, '2017-05-30 18:30:00', 'ytutyu', 'dfgdfg', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(3, '2017-05-25 03:09:10', 'ertetrert', 'testing', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(4, '2017-05-25 03:12:18', 'testing', 'testing', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(5, '2017-05-25 03:13:47', 'ghjhgj', 'ghj', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(6, '2017-05-25 21:08:00', 'ghfgh', 'fghfgh', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(7, '2017-05-25 22:16:24', 'rere', 're', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(8, '2017-05-25 22:16:48', 'ertert', 'rete', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(9, '2017-05-25 22:17:08', 'rtyrty', 'rytrytyutyutyu', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(10, '2017-05-25 22:19:01', '500', '500', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(11, '2017-05-25 22:29:19', 'tyutyutyu', 'tyutyu', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(12, '2017-05-25 22:29:42', 'tyutyu', 'tyutyu', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(13, '2017-05-25 22:32:22', 'tyutyu', 'yututyu', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(14, '2017-05-25 22:32:38', 'tyutyu', 'tutyu', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(15, '2017-05-25 22:32:43', 'tyutyu', 'tyutyu', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(16, '2017-05-25 22:32:46', 'tyutyu', 'tyuty', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(17, '2017-05-25 22:34:55', 'fghfgh', 'fgh', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(18, '2017-05-25 22:35:03', 'sdf', 'sdf', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(19, '2017-05-25 22:35:19', 'fg', 'fgh', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(20, '2017-05-25 22:35:34', 'dfg', 'fdfg', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(21, '2017-05-25 22:35:41', 'dfg', 'dfg', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(23, '2017-05-26 03:20:18', 'g', 'fh', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(24, '2017-05-26 03:50:04', 'dfgdfg', 'gdf', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(25, '2017-05-26 03:50:12', 'rty', 'rt', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(26, '2017-05-26 03:50:16', 'rty', 'rtyrt', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(28, '2017-05-26 04:07:43', 'tyu', 'tyu', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(29, '2017-05-26 04:07:47', '43', '43', 5, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(30, '2017-05-26 04:11:30', 'test', 'test', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(31, '2017-05-26 04:11:41', 'test', 'test', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(32, '2017-05-26 21:30:10', 'fgh', 'fghfgh', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(34, '2017-05-29 07:25:31', 'try', 'rty', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(35, '2017-05-29 07:35:51', '456456', '46', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(36, '2017-05-29 08:47:20', 'Testing', 'Testing', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(37, '2017-05-29 08:47:32', 'Testing', 'Testing', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(38, '2017-05-29 08:50:33', 'Testing', 'Testing', 4, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(41, '2017-05-29 08:53:41', 'ert', 'ert', 6, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(42, '2017-05-29 13:03:56', 'ghjgh', 'hgjghj', 4, 7, 0.000, 'Cash', 0, 0, 0.0000000000),
(43, '2017-05-29 14:55:15', '546456', '', 5, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(44, '2017-05-30 11:51:22', 'testing', '', 13, 7, 0.000, 'Cash', 0, 0, 0.0000000000),
(45, '2017-05-30 14:23:24', 'sample', 'test', 13, 7, 0.000, 'Cash', 0, 0, 0.0000000000),
(46, '2017-05-30 14:24:55', 'testing', '', 13, 7, 0.000, 'Cash', 0, 0, 0.0000000000),
(47, '2017-05-30 14:27:04', 'test', '', 13, 7, 0.000, 'Cash', 0, 0, 0.0000000000),
(48, '2017-05-30 14:27:45', 'testing', '', 13, 7, 0.000, 'Cash', 0, 0, 0.0000000000),
(49, '2017-05-30 14:27:55', 'testing', '', 13, 7, 0.000, 'Cash', 0, 0, 0.0000000000),
(50, '2017-05-30 14:49:36', '76', '', 15, 7, 0.000, 'Cash', 0, 0, 0.0000000000),
(51, '2017-06-01 13:51:06', 'dfgdfg', '', 13, 1, 0.000, 'Cash', 0, 0, 0.0000000000),
(52, '2017-06-05 12:16:06', '567', '', 13, 1, 51000.000, 'Cash', 2, 11, 0.0001200000),
(53, '2017-06-05 12:16:31', '567567', '5567', 13, 1, 320.000, 'Cash', 2, 11, 0.0001200000),
(54, '2017-06-06 14:52:23', 'Testing', '', 13, 1, 320.000, 'Cash', 2, 12, 0.5600000024),
(55, '2017-06-14 06:24:43', 'test', '550 rs - > 50 quantity', 14, 1, 550.000, 'Cash', 1, 1, 1.0000000000),
(56, '2017-06-14 06:35:02', 'Sample', '100 received', 14, 1, 550.000, 'Debit Card', 1, 1, 1.0000000000),
(57, '2017-06-16 08:18:51', 'test', '', 11, 1, 166.000, 'Cash', 1, 1, 1.0000000000),
(58, '2017-06-16 08:19:17', 'te', '', 11, 1, 100.000, 'Cash', 1, 1, 1.0000000000),
(59, '2017-06-19 14:45:01', 'Sample', 'test 252$', 13, 1, 450.000, 'Check', 2, 12, 0.5600000024),
(60, '2017-06-19 14:43:42', 'sample1', '756$', 13, 1, 1350.000, 'Credit Card', 2, 12, 0.5600000024),
(61, '2017-06-20 12:22:25', 'Ref001', 'tretret', 11, 1, 1800.000, 'Cash', 1, 1, 1.0000000000),
(62, '2017-06-20 13:39:58', 'f', 'f', 15, 1, 20.000, 'Cash', 1, 1, 1.0000000000),
(63, '2017-06-20 15:05:54', 'erww', 'ssa', 12, 1, 825.000, 'Cash', 1, 1, 1.0000000000),
(64, '2017-06-21 08:15:56', 'e', 'e', 12, 1, 1500.000, 'Debit Card', 1, 1, 1.0000000000);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_recpayment_made_receivings`
--

CREATE TABLE `ospos_recpayment_made_receivings` (
  `id` int(11) NOT NULL,
  `recpayment_made_id` int(11) NOT NULL,
  `receivings_id` int(11) NOT NULL,
  `amount` float(15,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_recpayment_made_receivings`
--

INSERT INTO `ospos_recpayment_made_receivings` (`id`, `recpayment_made_id`, `receivings_id`, `amount`) VALUES
(1, 45, 2, 600.000),
(2, 46, 2, 6114.000),
(3, 47, 3, 3805.000),
(4, 47, 4, 195.000),
(5, 48, 3, 40000.000),
(6, 49, 3, 286.000),
(7, 50, 12, 10000.000),
(8, 51, 14, 51000.000),
(9, 52, 16, 51000.000),
(10, 53, 18, 320.000),
(11, 54, 20, 320.000),
(12, 55, 54, 550.000),
(13, 56, 55, 550.000),
(14, 57, 63, 166.000),
(15, 58, 58, 100.000),
(16, 59, 84, 450.000),
(17, 60, 83, 1350.000),
(18, 61, 88, 1800.000),
(19, 62, 48, 10.000),
(20, 62, 49, 10.000),
(21, 63, 60, 240.000),
(22, 63, 62, 60.000),
(23, 63, 77, 100.000),
(24, 63, 78, 50.000),
(25, 63, 79, 25.000),
(26, 63, 81, 50.000),
(27, 63, 86, 300.000),
(28, 64, 108, 1500.000);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales`
--

CREATE TABLE `ospos_sales` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `invoice_number` varchar(32) DEFAULT NULL,
  `quote_number` varchar(32) DEFAULT NULL,
  `sale_id` int(10) NOT NULL,
  `sale_status` tinyint(2) NOT NULL DEFAULT '0',
  `dinner_table_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_sales`
--

INSERT INTO `ospos_sales` (`sale_time`, `customer_id`, `employee_id`, `comment`, `invoice_number`, `quote_number`, `sale_id`, `sale_status`, `dinner_table_id`) VALUES
('2017-05-30 11:59:50', 4, 10, '', '0', NULL, 1, 0, 1),
('2017-05-30 12:46:00', 4, 10, '', '1', NULL, 2, 0, 1),
('2017-05-30 13:56:56', 5, 1, '', '2', NULL, 3, 0, 1),
('2017-05-30 13:58:28', 6, 1, '', '3', NULL, 4, 0, 1),
('2017-05-30 15:36:50', 4, 1, '', '4', NULL, 5, 0, 1),
('2017-06-12 12:56:51', 3, 1, '', NULL, 'Q17000001', 8, 1, 1),
('2017-06-12 14:26:16', 6, 1, '', '100', NULL, 9, 0, 1),
('2017-06-12 14:28:27', 3, 1, 'test employee as admin 12/6/2017', '10000', NULL, 10, 0, 1),
('2017-06-12 15:00:48', 3, 1, '', '3424234', NULL, 11, 0, 1),
('2017-06-12 15:03:09', NULL, 1, 'Completed cash', '7rtret', NULL, 12, 0, 1),
('2017-06-12 15:21:00', 3, 1, '', '812345', NULL, 14, 0, 1),
('2017-06-15 07:45:21', 2, 1, '', '9', NULL, 15, 0, 1),
('2017-06-15 09:32:44', 2, 1, '40.37 Amount', '10', NULL, 16, 0, 1),
('2017-06-21 13:54:01', 26, 1, '', '11', NULL, 17, 0, 1),
('2017-06-21 13:59:06', 26, 1, '', '12', NULL, 18, 0, 1),
('2017-06-21 14:05:05', 26, 1, '', NULL, 'Q17000002', 19, 1, 1),
('2017-06-21 14:07:01', 26, 1, '', NULL, NULL, 20, 0, 1),
('2017-06-22 06:13:34', 26, 1, '', NULL, NULL, 21, 0, 1),
('2017-06-22 06:21:19', 26, 1, '', NULL, NULL, 22, 0, 1),
('2017-06-22 07:11:01', 26, 1, '', NULL, NULL, 24, 0, 1),
('2017-06-22 07:11:01', 26, 1, '', NULL, NULL, 25, 0, 1),
('2017-06-22 11:15:41', NULL, 1, '', NULL, NULL, 27, 0, 1),
('2017-06-22 11:28:43', 26, 1, 'Payme nt completed', '13', NULL, 28, 0, 1),
('2017-06-22 11:32:20', NULL, 1, '', NULL, NULL, 29, 0, 1),
('2017-06-22 11:33:44', NULL, 1, 'test', '14132345', NULL, 30, 0, 1),
('2017-06-22 11:38:39', NULL, 1, '', NULL, NULL, 31, 0, 1),
('2017-06-22 12:52:29', 26, 1, '', NULL, NULL, 33, 0, 1),
('2017-06-22 13:43:48', 26, 1, '', NULL, NULL, 34, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_items`
--

CREATE TABLE `ospos_sales_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` decimal(15,3) NOT NULL DEFAULT '0.000',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `discount_percent` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_location` int(11) NOT NULL,
  `print_option` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_sales_items`
--

INSERT INTO `ospos_sales_items` (`sale_id`, `item_id`, `description`, `serialnumber`, `line`, `quantity_purchased`, `item_cost_price`, `item_unit_price`, `discount_percent`, `item_location`, `print_option`) VALUES
(5, 1, '', '', 1, '100.000', '10.00', '12.00', '2.00', 6, 0),
(8, 1, '', '', 1, '1.000', '10.00', '12.00', '6.00', 4, 0),
(9, 1, '', '', 1, '2.000', '10.00', '12.00', '3.00', 4, 0),
(10, 2, '', '', 1, '1.000', '11.00', '13.00', '6.00', 4, 0),
(11, 4, '', '', 1, '4.000', '10.00', '15.00', '6.00', 6, 0),
(12, 4, '', '', 1, '5.000', '10.00', '15.00', '0.00', 6, 0),
(14, 4, '', '', 1, '1.000', '10.00', '15.00', '4.00', 6, 0),
(15, 1, '', '', 3, '1.000', '10.00', '12.00', '4.00', 6, 0),
(15, 2, '', '', 2, '2.000', '11.00', '13.00', '4.00', 6, 0),
(15, 3, '', '', 1, '2.000', '12.00', '14.00', '4.00', 6, 0),
(16, 10, 'Productname is \r\nPen ', '', 1, '3.000', '12.00', '13.00', '10.00', 6, 0),
(17, 13, '', '', 1, '1.000', '1500.00', '1000.00', '20.00', 6, 0),
(18, 13, '', '', 1, '1.000', '1500.00', '1000.00', '12.00', 6, 0),
(19, 13, '', '', 1, '1.000', '1500.00', '1000.00', '12.00', 6, 0),
(20, 13, '', '', 1, '1.000', '1500.00', '1000.00', '12.00', 6, 0),
(21, 20, '', '', 1, '2.000', '2000.00', '2200.00', '12.00', 6, 0),
(22, 20, '', '', 1, '-1.000', '2000.00', '2200.00', '12.00', 6, 0),
(24, 19, 'AC', '', 2, '1.000', '20000.00', '10000.00', '12.00', 5, 0),
(24, 20, '', '', 1, '1.000', '2000.00', '2200.00', '12.00', 5, 0),
(25, 19, 'AC', '', 2, '1.000', '20000.00', '10000.00', '12.00', 5, 0),
(25, 20, '', '', 1, '1.000', '2000.00', '2200.00', '12.00', 5, 0),
(27, 13, '', '', 1, '1.000', '1500.00', '1000.00', '0.00', 5, 0),
(28, 13, '', '', 1, '1.000', '1500.00', '1000.00', '12.00', 5, 0),
(29, 13, '', '', 1, '2.000', '1500.00', '1000.00', '0.00', 6, 0),
(30, 13, '', '', 1, '1.000', '1500.00', '1000.00', '0.00', 6, 0),
(31, 13, '', '', 1, '1.000', '1500.00', '1000.00', '0.00', 6, 0),
(33, 20, '', '', 1, '1.000', '2000.00', '2200.00', '12.00', 5, 0),
(34, 13, '', '', 1, '1.000', '1500.00', '1000.00', '12.00', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_items_taxes`
--

CREATE TABLE `ospos_sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax_type` tinyint(2) NOT NULL DEFAULT '0',
  `rounding_code` tinyint(2) NOT NULL DEFAULT '0',
  `cascade_tax` tinyint(2) NOT NULL DEFAULT '0',
  `cascade_sequence` tinyint(2) NOT NULL DEFAULT '0',
  `item_tax_amount` decimal(15,4) NOT NULL DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_sales_items_taxes`
--

INSERT INTO `ospos_sales_items_taxes` (`sale_id`, `item_id`, `line`, `name`, `percent`, `tax_type`, `rounding_code`, `cascade_tax`, `cascade_sequence`, `item_tax_amount`) VALUES
(5, 1, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '117.6000'),
(8, 1, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '1.1300'),
(9, 1, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '2.3300'),
(10, 2, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '1.2200'),
(11, 4, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '5.6400'),
(12, 4, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '7.5000'),
(14, 4, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '1.4400'),
(15, 1, 3, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '1.1500'),
(15, 2, 2, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '2.5000'),
(15, 3, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '2.6900'),
(16, 10, 1, 'Eng at standard rate', '5.0000', 1, 0, 0, 0, '1.7600'),
(16, 10, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '3.5100'),
(17, 13, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '80.0000'),
(18, 13, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '88.0000'),
(19, 13, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '88.0000'),
(20, 13, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '88.0000'),
(21, 20, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '387.2000'),
(22, 20, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '-193.6000'),
(24, 19, 2, 'Laos at a standard rate', '20.0000', 1, 0, 0, 0, '1760.0000'),
(24, 20, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '193.6000'),
(25, 19, 2, 'Laos at a standard rate', '20.0000', 1, 0, 0, 0, '1760.0000'),
(25, 20, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '193.6000'),
(27, 13, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '100.0000'),
(28, 13, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '88.0000'),
(29, 13, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '200.0000'),
(30, 13, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '100.0000'),
(31, 13, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '100.0000'),
(33, 20, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '193.6000'),
(34, 13, 1, 'Laos at a standard rate', '10.0000', 1, 0, 0, 0, '88.0000');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_payments`
--

CREATE TABLE `ospos_sales_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_sales_payments`
--

INSERT INTO `ospos_sales_payments` (`sale_id`, `payment_type`, `payment_amount`) VALUES
(5, 'Cash', '1293.60'),
(8, 'Cash', '13.20'),
(9, 'Cash', '25.61'),
(10, 'Debit Card', '13.44'),
(11, 'Cash', '62.04'),
(12, 'Cash', '82.50'),
(14, 'Cash', '15.84'),
(15, 'Cash', '69.70'),
(16, 'Cash', '40.37'),
(17, 'Cash', '880.00'),
(18, 'Cash', '968.00'),
(19, 'Debit Card', '968.00'),
(22, 'Cash', '-2129.60'),
(27, 'Cash', '1090.00'),
(27, 'Gift Card:567567', '10.00'),
(28, 'Cash', '1090.00'),
(28, 'Gift Card:567567', '10.00'),
(29, 'Cash', '2190.00'),
(29, 'Gift Card:567567', '10.00'),
(30, 'Cash', '1090.00'),
(30, 'Gift Card:567567', '10.00'),
(31, 'Cash', '1090.00'),
(31, 'Gift Card:567567', '10.00'),
(33, 'Debit Card', '2129.60'),
(34, 'Cash', '968.00');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_reward_points`
--

CREATE TABLE `ospos_sales_reward_points` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `earned` float NOT NULL,
  `used` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended`
--

CREATE TABLE `ospos_sales_suspended` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `invoice_number` varchar(32) DEFAULT NULL,
  `quote_number` varchar(32) DEFAULT NULL,
  `sale_id` int(10) NOT NULL,
  `dinner_table_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended_items`
--

CREATE TABLE `ospos_sales_suspended_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` decimal(15,3) NOT NULL DEFAULT '0.000',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `discount_percent` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_location` int(11) NOT NULL,
  `print_option` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended_items_taxes`
--

CREATE TABLE `ospos_sales_suspended_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended_payments`
--

CREATE TABLE `ospos_sales_suspended_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_taxes`
--

CREATE TABLE `ospos_sales_taxes` (
  `sale_id` int(10) NOT NULL,
  `tax_type` smallint(2) NOT NULL,
  `tax_group` varchar(32) NOT NULL,
  `sale_tax_basis` decimal(15,4) NOT NULL,
  `sale_tax_amount` decimal(15,4) NOT NULL,
  `print_sequence` tinyint(2) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `tax_rate` decimal(15,4) NOT NULL,
  `sales_tax_code` varchar(32) NOT NULL DEFAULT '',
  `rounding_code` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_sales_taxes`
--

INSERT INTO `ospos_sales_taxes` (`sale_id`, `tax_type`, `tax_group`, `sale_tax_basis`, `sale_tax_amount`, `print_sequence`, `name`, `tax_rate`, `sales_tax_code`, `rounding_code`) VALUES
(1, 1, '10% Laos at a standard rate', '8722.0000', '872.2000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(2, 1, '10% Laos at a standard rate', '58.8000', '5.9000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(3, 1, '10% Laos at a standard rate', '35.1000', '3.5100', 0, 'Laos at a standard rate', '10.0000', '', 0),
(4, 1, '10% Laos at a standard rate', '23.2800', '2.3200', 0, 'Laos at a standard rate', '10.0000', '', 0),
(5, 1, '10% Laos at a standard rate', '1176.0000', '117.6000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(8, 1, '10% Laos at a standard rate', '11.2800', '1.1300', 0, 'Laos at a standard rate', '10.0000', '', 0),
(9, 1, '10% Laos at a standard rate', '23.2800', '2.3300', 0, 'Laos at a standard rate', '10.0000', '', 0),
(10, 1, '10% Laos at a standard rate', '12.2200', '1.2200', 0, 'Laos at a standard rate', '10.0000', '', 0),
(11, 1, '10% Laos at a standard rate', '56.4000', '5.6400', 0, 'Laos at a standard rate', '10.0000', '', 0),
(12, 1, '10% Laos at a standard rate', '75.0000', '7.5000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(14, 1, '10% Laos at a standard rate', '14.4000', '1.4400', 0, 'Laos at a standard rate', '10.0000', '', 0),
(15, 1, '10% Laos at a standard rate', '63.3600', '6.3400', 0, 'Laos at a standard rate', '10.0000', '', 0),
(16, 1, '10% Laos at a standard rate', '35.1000', '3.5100', 1, 'Laos at a standard rate', '10.0000', '', 0),
(16, 1, '5% Eng at standard rate', '35.1000', '1.7600', 0, 'Eng at standard rate', '5.0000', '', 0),
(17, 1, '10% Laos at a standard rate', '800.0000', '80.0000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(18, 1, '10% Laos at a standard rate', '880.0000', '88.0000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(19, 1, '10% Laos at a standard rate', '880.0000', '88.0000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(20, 1, '10% Laos at a standard rate', '880.0000', '88.0000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(21, 1, '10% Laos at a standard rate', '3872.0000', '387.2000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(22, 1, '10% Laos at a standard rate', '-1936.0000', '-193.6000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(24, 1, '10% Laos at a standard rate', '1936.0000', '193.6000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(24, 1, '20% Laos at a standard rate', '8800.0000', '1760.0000', 0, 'Laos at a standard rate', '20.0000', '', 0),
(25, 1, '10% Laos at a standard rate', '1936.0000', '193.6000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(25, 1, '20% Laos at a standard rate', '8800.0000', '1760.0000', 0, 'Laos at a standard rate', '20.0000', '', 0),
(27, 1, '10% Laos at a standard rate', '1000.0000', '100.0000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(28, 1, '10% Laos at a standard rate', '880.0000', '88.0000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(29, 1, '10% Laos at a standard rate', '2000.0000', '200.0000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(30, 1, '10% Laos at a standard rate', '1000.0000', '100.0000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(31, 1, '10% Laos at a standard rate', '1000.0000', '100.0000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(33, 1, '10% Laos at a standard rate', '1936.0000', '193.6000', 0, 'Laos at a standard rate', '10.0000', '', 0),
(34, 1, '10% Laos at a standard rate', '880.0000', '88.0000', 0, 'Laos at a standard rate', '10.0000', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sessions`
--

CREATE TABLE `ospos_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_sessions`
--

INSERT INTO `ospos_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('tq8mr16hmu07nlod689oggo63ksudpip', '192.168.5.75', 1498537616, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383533373631363b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('me45k897f3ue6lg6g5c64pkmqemvojqn', '192.168.5.75', 1498539833, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383533393833333b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('i2k2sqn5ig3b0nlhfo6q7e3s7b55bc0b', '192.168.5.75', 1498540304, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383534303330343b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b726563765f73746f636b5f736f757263657c733a313a2233223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2232223b726563765f636172747c613a313a7b693a333b613a31353a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2233223b733a31303a2273746f636b5f6e616d65223b733a32303a224d61612046616c6f64692057617265686f757365223b733a343a226c696e65223b693a333b733a343a226e616d65223b733a31333a224170706c65206950686f6e6536223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a303a22223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2230223b733a31333a2269735f73657269616c697a6564223b733a313a2230223b733a383a227175616e74697479223b733a363a2231302e303030223b733a383a22646973636f756e74223b693a303b733a383a22696e5f73746f636b223b733a383a22323937312e303030223b733a353a227072696365223b733a353a2231302e3030223b733a31383a22726563656976696e675f7175616e74697479223b733a363a2231302e303030223b733a353a22746f74616c223b733a373a2231302e30303030223b7d7d726563765f726563656976696e675f7374617475737c733a353a226472616674223b726563765f737570706c6965727c693a2d313b726563765f6d6f64657c733a373a2272656365697665223b),
('qoohj1vioik7kt8uochsu7sur1gqoal8', '192.168.5.75', 1498543207, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383534333230373b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b726563765f73746f636b5f736f757263657c733a313a2233223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2232223b),
('ugqfljuvulnocgddlhmm1rhj1b1mira2', '192.168.5.75', 1498543887, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383534333838373b706572736f6e5f69647c733a313a2238223b656d706c6f796565735f6c6f67696e7c733a393a2277617265686f757365223b6c616e67756167655f636f64657c733a323a22656e223b),
('p35hhv97nahlrt2bah4j2dfcleo8o14v', '192.168.5.75', 1498544048, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383534343034383b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b726563765f73746f636b5f736f757263657c733a313a2233223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2232223b),
('bir35334gfas8lip0695du051c2jbb0o', '192.168.5.75', 1498546433, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383534363433333b706572736f6e5f69647c733a313a2238223b656d706c6f796565735f6c6f67696e7c733a393a2277617265686f757365223b6c616e67756167655f636f64657c733a323a22656e223b),
('dc82c4huj0hvs0j0bkls4ud04ubru4uq', '192.168.5.75', 1498546279, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383534343034383b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b726563765f73746f636b5f736f757263657c733a313a2233223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2232223b),
('837rvu82ob6fhido6c35ovjn35i4m6nb', '192.168.5.75', 1498548525, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383534383532353b706572736f6e5f69647c733a313a2238223b656d706c6f796565735f6c6f67696e7c733a393a2277617265686f757365223b6c616e67756167655f636f64657c733a323a22656e223b),
('2er7n7g0nt5j45v6vfva95m5kjumntak', '192.168.5.75', 1498548547, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383534383532353b706572736f6e5f69647c733a313a2238223b656d706c6f796565735f6c6f67696e7c733a393a2277617265686f757365223b6c616e67756167655f636f64657c733a323a22656e223b),
('0chjttkkcn953kfn62v96dmnhdnmjj8l', '223.30.193.83', 1498548672, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383534383637323b),
('61qf9e87n7024hcc70hmgl78jbugq6pt', '192.168.5.75', 1498557235, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383535373233353b),
('mv9s8r7d99grlvu0qhghmju9mbn4ep5m', '192.168.5.88', 1498558444, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383535383434343b),
('1ho18meernrro2b25lp7cr5htv1favm1', '192.168.5.88', 1498645995, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383634353939353b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b6974656d5f6c6f636174696f6e7c733a313a2236223b),
('ve6sfklk7paue2qg51j54epfac6puahq', '192.168.5.88', 1498645995, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383634353939353b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b6974656d5f6c6f636174696f6e7c733a313a2236223b),
('f01s34849ued3d8gol1rqp41ficuemcd', '192.168.5.88', 1498708363, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383730383336323b),
('dbb602at4n8antcjt6m8a88i9jb01kfi', '192.168.5.75', 1498710732, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383731303733323b),
('h721994a1ivoeksiulfam457c5ufp6ar', '192.168.5.75', 1498720336, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383732303333363b),
('ss0vuibce5jbd6opttlnl8g5eun3aodl', '::1', 1498717996, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383731373936393b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b6974656d5f6c6f636174696f6e7c733a313a2236223b),
('foobstoj156u7nob9prr288dh64n6jib', '192.168.5.95', 1498718565, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383731383438303b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b73616c65735f636172747c613a303a7b7d73616c65735f637573746f6d65727c693a2d313b73616c65735f6d6f64657c733a31323a2273616c655f696e766f696365223b64696e6e65725f7461626c657c693a313b73616c65735f6c6f636174696f6e7c733a313a2236223b73616c65735f7061796d656e74737c613a303a7b7d636173685f6d6f64657c693a313b636173685f726f756e64696e677c693a303b73616c65735f696e766f6963655f6e756d6265727c4e3b6974656d5f6c6f636174696f6e7c733a313a2236223b),
('apciosvmrluvr9htcvet1a5r6h2lec3m', '192.168.5.95', 1498720343, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383732303334333b),
('0ru2l6t1hi32392g8k1c3up2u82krdob', '192.168.5.95', 1498720343, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383732303334333b),
('k7bckb5dsvqtnb4n53vmj0gubko6bqdr', '192.168.5.75', 1498720349, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383732303334393b),
('lhsrearpgg1uj2petf4nufehk08uk38j', '192.168.5.75', 1498742263, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383734323236333b),
('lei0cuer1phmeqhm38j6a7soefns0alt', '192.168.5.75', 1498742263, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439383734323236333b),
('7hkkg9uh6tjr5188k8h2qetoolp9ego7', '223.30.193.83', 1499056085, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393035363038323b),
('vgi3v2m0itulflisg1q9ms57aom9u7r9', '::1', 1499087216, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393038373230373b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('8d7fc99abcqf7l6vk6prca991hp13e98', '192.168.5.96', 1499423021, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393432333030383b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('3hhtflo6gpgin24roe321j637mct3s3u', '192.168.5.95', 1499667594, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393636373539343b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b5245515f73746f636b5f736f757263657c733a313a2232223b5245515f636172747c613a303a7b7d),
('mvd0487beapjevb2lrdkcsb0dlmbfn91', '192.168.5.95', 1499667594, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393636373539343b),
('2a2nmgjmafkptp0ap9p7qm4oeeduru2t', '192.168.5.127', 1500029242, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303032393232323b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('cu8d96khj02a4od2gvbb8409fj7gvkq6', '::1', 1500553906, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303535333838383b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('0qr5n0gp96pukk94s5fte2i4qnffu6d7', '192.168.5.96', 1500961145, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530303936313134333b),
('d4l0lps4q3thuq55cvdcdfcnjf61i451', '::1', 1501227988, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530313232373938353b),
('j9t90v06s72gpmpr4dopldno169jqf52', '192.168.5.124', 1501743128, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530313734333130373b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('c11cbk45el7s9uidl2g48brkmpoutrr5', '192.168.5.95', 1501743314, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530313734333331343b),
('789t52sklvrt4k3nko38h3dl9h3bgdg8', '::1', 1502258459, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530323235383435363b),
('knrdenos3f3rp27u7g9rjaq8vlp02si8', '192.168.5.124', 1502345822, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530323334353832313b),
('s2j3urqsq423hl02elg9pjoq48fq0vce', '192.168.5.88', 1503462161, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530333436313936323b),
('1j6r5f8a6g1ru78j1fo1uu11d9nfn0o0', '192.168.5.88', 1503489974, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530333438393937323b),
('ki3svqvtlj8ut13jelko5i4c4cgfn0qj', '192.168.5.127', 1503986696, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530333938363637353b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('s941hh25at4bqacc1r88f7oqeoiajut0', '192.168.5.127', 1504004022, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530343030343031393b),
('ke739cqqtjo8l35oa8c0guq6qj8rr2r6', '::1', 1504499548, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530343439393534343b),
('v1vd05gt1lv9mlftf26tks2jask5hp1i', '::1', 1504675511, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530343637353530383b),
('r0i4vgm6oikdfciu2ojdfjc3s9t7mos4', '192.168.5.127', 1505742997, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530353734323932323b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('huos3f8d4vm2e1dpb3ca8bt4dg28ac08', '::1', 1507523519, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530373532333530333b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('328g8k1vfrj2c18ck65uafl5cvi2bh25', '::1', 1508130958, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530383133303935363b),
('je07dof4pcvfefdqdtlamtbnqei2h56m', '192.168.5.88', 1508734596, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530383733343539313b),
('vhmllg21etjokrc3u01qks5n5d11pi2i', '192.168.5.88', 1508909050, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530383930393034333b),
('d2pg1edbi2fjmted5ofgtc85c0mq9loi', '::1', 1509336931, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530393333363932393b),
('3c2m6rnhhtq1ojutq7ke209b5q4t2ja7', '192.168.5.95', 1509683525, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530393638333532323b),
('hsbqp53mrp5ics081ic47hsfgonl6a75', '192.168.5.95', 1510549095, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531303534393039323b),
('3265fpq7k7ul7asjtde7tg5t4ef8n8ms', '127.0.0.1', 1513054559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531333035343535393b),
('u2j0dreogkscahmsvo2rcft26go1sks5', '127.0.0.1', 1513055415, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531333035353431353b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('2sgev8rj2hfn8ms8ci0na2qh765er9fm', '127.0.0.1', 1513055702, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531333035353536353b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('1nrbtvllc26fbj9050f6eulhkpmkccvk', '127.0.0.1', 1516097290, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531363039373237363b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b),
('66eudv6bdcorr1ov8fsd39m6mq8i1d8b', '127.0.0.1', 1527075528, 0x5f5f63695f6c6173745f726567656e65726174657c693a313532373037353432353b706572736f6e5f69647c733a313a2231223b656d706c6f796565735f6c6f67696e7c733a31303a22686561646f6666696365223b6c616e67756167655f636f64657c733a323a22656e223b6974656d5f6c6f636174696f6e7c733a313a2234223b73616c65735f636172747c613a303a7b7d73616c65735f637573746f6d65727c693a2d313b73616c65735f6d6f64657c733a31323a2273616c655f696e766f696365223b64696e6e65725f7461626c657c693a313b73616c65735f6c6f636174696f6e7c733a313a2234223b73616c65735f7061796d656e74737c613a303a7b7d636173685f6d6f64657c693a313b636173685f726f756e64696e677c693a303b73616c65735f696e766f6963655f6e756d6265727c4e3b726563765f636172747c613a303a7b7d726563765f73746f636b5f736f757263657c733a313a2232223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2232223b726563765f726563656976696e675f7374617475737c733a353a226472616674223b726563765f737570706c6965727c693a2d313b);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_stock_locations`
--

CREATE TABLE `ospos_stock_locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `location_type` enum('store','warehouse') NOT NULL DEFAULT 'store',
  `phone_number` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_stock_locations`
--

INSERT INTO `ospos_stock_locations` (`location_id`, `location_name`, `location_type`, `phone_number`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `deleted`) VALUES
(1, 'Store', 'store', '', '', '', '', '', '', '', 1),
(2, 'shree krishna warehoue', 'warehouse', '9765445453', 'VILLEGE SAREKHA KHURD, POST DONDIWARA, TEHSIL BARGHAT, DIST. ', '', 'Jabalpur', 'Delhi', '96556', 'India', 0),
(3, 'Maa Falodi Warehouse', 'warehouse', '56767777', 'MAHESH AGRAWAL WARD NO. 12 , NEW RAILWAY STATION ROAD,CHATERA KATANGI-481445', '', 'Bhopal', 'Maharastra', '954566', 'India', 0),
(4, 'Sivaksi Store', 'store', '9889896767', '91, Gurnet Road', '', 'Sivakasi', 'Kerala', '7455333', 'United States', 0),
(5, 'Nellai Store', 'store', '78688786', '41, Sherman Road Street', '', 'Tirunelveli', 'Tamilnadu', '624455', 'India', 0),
(6, 'Alwa Store', 'store', '767676767', 'Nellaiappar kovil street', '', 'Tirunelveli', 'Tamilnadu', '633233', 'India', 0),
(7, 'Rajaplayam Dubagore Store', 'store', '', '', '', '', '', '', '', 1),
(8, 'Anand Store', 'store', '886676767', '52, Highway millinum road', '', 'Kadayanallur', 'Andhrapradesh', '63443', 'Australia', 0),
(9, 'shree krishna warehoue', 'warehouse', '', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_suppliers`
--

CREATE TABLE `ospos_suppliers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `agency_name` varchar(255) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_suppliers`
--

INSERT INTO `ospos_suppliers` (`person_id`, `company_name`, `agency_name`, `account_id`, `deleted`) VALUES
(11, 'LTX Corporation', '', 59, 0),
(12, 'Marsh Inc', '', 60, 0),
(13, 'FMC Corporation', '', 61, 0),
(14, 'Kinpo Electronics Inc', '', 62, 0),
(15, 'Siltronic AG', '', 63, 0),
(18, '', '', 66, 0),
(36, '', '', 67, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_tax_categories`
--

CREATE TABLE `ospos_tax_categories` (
  `tax_category_id` int(10) NOT NULL,
  `tax_category` varchar(32) NOT NULL,
  `tax_group_sequence` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_tax_categories`
--

INSERT INTO `ospos_tax_categories` (`tax_category_id`, `tax_category`, `tax_group_sequence`) VALUES
(0, 'Standard', 10),
(1, 'Service', 12),
(2, 'Alcohol', 11);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_tax_codes`
--

CREATE TABLE `ospos_tax_codes` (
  `tax_code` varchar(32) NOT NULL,
  `tax_code_name` varchar(255) NOT NULL DEFAULT '',
  `tax_code_type` tinyint(2) NOT NULL DEFAULT '0',
  `city` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_tax_codes`
--

INSERT INTO `ospos_tax_codes` (`tax_code`, `tax_code_name`, `tax_code_type`, `city`, `state`) VALUES
('45', '6456', 0, '456', '456');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_tax_code_rates`
--

CREATE TABLE `ospos_tax_code_rates` (
  `rate_tax_code` varchar(32) NOT NULL,
  `rate_tax_category_id` int(10) NOT NULL,
  `tax_rate` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `rounding_code` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_tax_code_rates`
--

INSERT INTO `ospos_tax_code_rates` (`rate_tax_code`, `rate_tax_category_id`, `tax_rate`, `rounding_code`) VALUES
('45', 0, '50.0000', 0),
('45', 1, '43.0000', 0),
('45', 2, '43.0000', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ospos_account`
--
ALTER TABLE `ospos_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_account_trans`
--
ALTER TABLE `ospos_account_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_app_config`
--
ALTER TABLE `ospos_app_config`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `ospos_audit_trail`
--
ALTER TABLE `ospos_audit_trail`
  ADD PRIMARY KEY (`audit_trail_id`);

--
-- Indexes for table `ospos_contactus`
--
ALTER TABLE `ospos_contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_currency`
--
ALTER TABLE `ospos_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_currency_rate`
--
ALTER TABLE `ospos_currency_rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_customers`
--
ALTER TABLE `ospos_customers`
  ADD UNIQUE KEY `account_number` (`account_number`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `ospos_customers_packages`
--
ALTER TABLE `ospos_customers_packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `ospos_customers_points`
--
ALTER TABLE `ospos_customers_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_dinner_tables`
--
ALTER TABLE `ospos_dinner_tables`
  ADD PRIMARY KEY (`dinner_table_id`);

--
-- Indexes for table `ospos_employees`
--
ALTER TABLE `ospos_employees`
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `ospos_employees_role`
--
ALTER TABLE `ospos_employees_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_expenses`
--
ALTER TABLE `ospos_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_giftcards`
--
ALTER TABLE `ospos_giftcards`
  ADD PRIMARY KEY (`giftcard_id`),
  ADD UNIQUE KEY `giftcard_number` (`giftcard_number`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `ospos_grants`
--
ALTER TABLE `ospos_grants`
  ADD PRIMARY KEY (`permission_id`,`person_id`),
  ADD KEY `ospos_grants_ibfk_2` (`person_id`);

--
-- Indexes for table `ospos_income`
--
ALTER TABLE `ospos_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_inventory`
--
ALTER TABLE `ospos_inventory`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `trans_items` (`trans_items`),
  ADD KEY `trans_user` (`trans_user`),
  ADD KEY `trans_location` (`trans_location`);

--
-- Indexes for table `ospos_inventory_adjustments`
--
ALTER TABLE `ospos_inventory_adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_items`
--
ALTER TABLE `ospos_items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `item_number` (`item_number`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `ospos_items_taxes`
--
ALTER TABLE `ospos_items_taxes`
  ADD PRIMARY KEY (`item_id`,`name`,`percent`);

--
-- Indexes for table `ospos_item_kits`
--
ALTER TABLE `ospos_item_kits`
  ADD PRIMARY KEY (`item_kit_id`);

--
-- Indexes for table `ospos_item_kit_items`
--
ALTER TABLE `ospos_item_kit_items`
  ADD PRIMARY KEY (`item_kit_id`,`item_id`,`quantity`),
  ADD KEY `ospos_item_kit_items_ibfk_2` (`item_id`);

--
-- Indexes for table `ospos_item_price`
--
ALTER TABLE `ospos_item_price`
  ADD PRIMARY KEY (`item_id`,`location_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `ospos_item_promo`
--
ALTER TABLE `ospos_item_promo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_item_quantities`
--
ALTER TABLE `ospos_item_quantities`
  ADD PRIMARY KEY (`item_id`,`location_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `ospos_modules`
--
ALTER TABLE `ospos_modules`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `desc_lang_key` (`desc_lang_key`),
  ADD UNIQUE KEY `name_lang_key` (`name_lang_key`);

--
-- Indexes for table `ospos_people`
--
ALTER TABLE `ospos_people`
  ADD PRIMARY KEY (`person_id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `ospos_permissions`
--
ALTER TABLE `ospos_permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `ospos_permissions_ibfk_2` (`location_id`);

--
-- Indexes for table `ospos_receivings`
--
ALTER TABLE `ospos_receivings`
  ADD PRIMARY KEY (`receiving_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `reference` (`reference`);

--
-- Indexes for table `ospos_receivings_items`
--
ALTER TABLE `ospos_receivings_items`
  ADD PRIMARY KEY (`receiving_id`,`item_id`,`line`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `ospos_recpayment_made`
--
ALTER TABLE `ospos_recpayment_made`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_recpayment_made_receivings`
--
ALTER TABLE `ospos_recpayment_made_receivings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_sales`
--
ALTER TABLE `ospos_sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `sale_time` (`sale_time`),
  ADD KEY `dinner_table_id` (`dinner_table_id`);

--
-- Indexes for table `ospos_sales_items`
--
ALTER TABLE `ospos_sales_items`
  ADD PRIMARY KEY (`sale_id`,`item_id`,`line`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `item_location` (`item_location`);

--
-- Indexes for table `ospos_sales_items_taxes`
--
ALTER TABLE `ospos_sales_items_taxes`
  ADD PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `ospos_sales_payments`
--
ALTER TABLE `ospos_sales_payments`
  ADD PRIMARY KEY (`sale_id`,`payment_type`),
  ADD KEY `sale_id` (`sale_id`);

--
-- Indexes for table `ospos_sales_reward_points`
--
ALTER TABLE `ospos_sales_reward_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_sales_suspended`
--
ALTER TABLE `ospos_sales_suspended`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `dinner_table_id` (`dinner_table_id`);

--
-- Indexes for table `ospos_sales_suspended_items`
--
ALTER TABLE `ospos_sales_suspended_items`
  ADD PRIMARY KEY (`sale_id`,`item_id`,`line`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `ospos_sales_suspended_items_ibfk_3` (`item_location`);

--
-- Indexes for table `ospos_sales_suspended_items_taxes`
--
ALTER TABLE `ospos_sales_suspended_items_taxes`
  ADD PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `ospos_sales_suspended_payments`
--
ALTER TABLE `ospos_sales_suspended_payments`
  ADD PRIMARY KEY (`sale_id`,`payment_type`);

--
-- Indexes for table `ospos_sales_taxes`
--
ALTER TABLE `ospos_sales_taxes`
  ADD PRIMARY KEY (`sale_id`,`tax_type`,`tax_group`),
  ADD KEY `print_sequence` (`sale_id`,`print_sequence`,`tax_type`,`tax_group`);

--
-- Indexes for table `ospos_sessions`
--
ALTER TABLE `ospos_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `ospos_stock_locations`
--
ALTER TABLE `ospos_stock_locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `ospos_suppliers`
--
ALTER TABLE `ospos_suppliers`
  ADD UNIQUE KEY `account_number` (`account_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `ospos_tax_categories`
--
ALTER TABLE `ospos_tax_categories`
  ADD PRIMARY KEY (`tax_category_id`);

--
-- Indexes for table `ospos_tax_codes`
--
ALTER TABLE `ospos_tax_codes`
  ADD PRIMARY KEY (`tax_code`);

--
-- Indexes for table `ospos_tax_code_rates`
--
ALTER TABLE `ospos_tax_code_rates`
  ADD PRIMARY KEY (`rate_tax_code`,`rate_tax_category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ospos_account`
--
ALTER TABLE `ospos_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `ospos_account_trans`
--
ALTER TABLE `ospos_account_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=795;
--
-- AUTO_INCREMENT for table `ospos_audit_trail`
--
ALTER TABLE `ospos_audit_trail`
  MODIFY `audit_trail_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;
--
-- AUTO_INCREMENT for table `ospos_contactus`
--
ALTER TABLE `ospos_contactus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ospos_currency`
--
ALTER TABLE `ospos_currency`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ospos_currency_rate`
--
ALTER TABLE `ospos_currency_rate`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `ospos_customers_packages`
--
ALTER TABLE `ospos_customers_packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ospos_customers_points`
--
ALTER TABLE `ospos_customers_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ospos_dinner_tables`
--
ALTER TABLE `ospos_dinner_tables`
  MODIFY `dinner_table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ospos_employees_role`
--
ALTER TABLE `ospos_employees_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ospos_expenses`
--
ALTER TABLE `ospos_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ospos_giftcards`
--
ALTER TABLE `ospos_giftcards`
  MODIFY `giftcard_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ospos_income`
--
ALTER TABLE `ospos_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ospos_inventory`
--
ALTER TABLE `ospos_inventory`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT for table `ospos_inventory_adjustments`
--
ALTER TABLE `ospos_inventory_adjustments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ospos_items`
--
ALTER TABLE `ospos_items`
  MODIFY `item_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `ospos_item_kits`
--
ALTER TABLE `ospos_item_kits`
  MODIFY `item_kit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ospos_item_promo`
--
ALTER TABLE `ospos_item_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ospos_people`
--
ALTER TABLE `ospos_people`
  MODIFY `person_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `ospos_receivings`
--
ALTER TABLE `ospos_receivings`
  MODIFY `receiving_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `ospos_recpayment_made`
--
ALTER TABLE `ospos_recpayment_made`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `ospos_recpayment_made_receivings`
--
ALTER TABLE `ospos_recpayment_made_receivings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `ospos_sales`
--
ALTER TABLE `ospos_sales`
  MODIFY `sale_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `ospos_sales_reward_points`
--
ALTER TABLE `ospos_sales_reward_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ospos_sales_suspended`
--
ALTER TABLE `ospos_sales_suspended`
  MODIFY `sale_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ospos_stock_locations`
--
ALTER TABLE `ospos_stock_locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ospos_customers`
--
ALTER TABLE `ospos_customers`
  ADD CONSTRAINT `ospos_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `ospos_people` (`person_id`);

--
-- Constraints for table `ospos_employees`
--
ALTER TABLE `ospos_employees`
  ADD CONSTRAINT `ospos_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `ospos_people` (`person_id`);

--
-- Constraints for table `ospos_giftcards`
--
ALTER TABLE `ospos_giftcards`
  ADD CONSTRAINT `ospos_giftcards_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `ospos_people` (`person_id`);

--
-- Constraints for table `ospos_grants`
--
ALTER TABLE `ospos_grants`
  ADD CONSTRAINT `ospos_grants_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `ospos_permissions` (`permission_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ospos_grants_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `ospos_employees_role` (`id`);

--
-- Constraints for table `ospos_inventory`
--
ALTER TABLE `ospos_inventory`
  ADD CONSTRAINT `ospos_inventory_ibfk_1` FOREIGN KEY (`trans_items`) REFERENCES `ospos_items` (`item_id`),
  ADD CONSTRAINT `ospos_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `ospos_employees` (`person_id`),
  ADD CONSTRAINT `ospos_inventory_ibfk_3` FOREIGN KEY (`trans_location`) REFERENCES `ospos_stock_locations` (`location_id`);

--
-- Constraints for table `ospos_items`
--
ALTER TABLE `ospos_items`
  ADD CONSTRAINT `ospos_items_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `ospos_suppliers` (`person_id`);

--
-- Constraints for table `ospos_items_taxes`
--
ALTER TABLE `ospos_items_taxes`
  ADD CONSTRAINT `ospos_items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `ospos_item_kit_items`
--
ALTER TABLE `ospos_item_kit_items`
  ADD CONSTRAINT `ospos_item_kit_items_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `ospos_item_kits` (`item_kit_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ospos_item_kit_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `ospos_item_price`
--
ALTER TABLE `ospos_item_price`
  ADD CONSTRAINT `ospos_item_price_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`),
  ADD CONSTRAINT `ospos_item_price_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `ospos_stock_locations` (`location_id`);

--
-- Constraints for table `ospos_item_quantities`
--
ALTER TABLE `ospos_item_quantities`
  ADD CONSTRAINT `ospos_item_quantities_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`),
  ADD CONSTRAINT `ospos_item_quantities_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `ospos_stock_locations` (`location_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
