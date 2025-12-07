-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 27, 2025 at 10:43 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `year` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `description` text,
  `cover_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `year`, `quantity`, `link`, `description`, `cover_image`) VALUES
(2, 'Nhà giả kim', 'Paulo Coelho', 'novel', 1988, 3, 'https://nhasachmienphi.com/nha-gia-kim.html', 'Tất cả những trải nghiệm trong chuyến phiêu du theo đuổi vận mệnh của mình đã giúp Santiago thấu hiểu được ý nghĩa sâu xa nhất của hạnh phúc, hòa hợp với vũ trụ và con người.\r\n\r\nTiểu thuyết Nhà giả kim của Paulo Coelho như một câu chuyện cổ tích giản dị, nhân ái, giàu chất thơ, thấm đẫm những minh triết huyền bí của phương Đông. Trong lần xuất bản đầu tiên tại Brazil vào năm 1988, sách chỉ bán được 900 bản. Nhưng, với số phận đặc biệt của cuốn sách dành cho toàn nhân loại, vượt ra ngoài biên giới quốc gia, Nhà giả kim đã làm rung động hàng triệu tâm hồn, trở thành một trong những cuốn sách bán chạy nhất mọi thời đại, và có thể làm thay đổi cuộc đời người đọc.\r\n\r\n“Nhưng nhà luyện kim đan không quan tâm mấy đến những điều ấy. Ông đã từng thấy nhiều người đến rồi đi, trong khi ốc đảo và sa mạc vẫn là ốc đảo và sa mạc. Ông đã thấy vua chúa và kẻ ăn xin đi qua biển cát này, cái biển cát thường xuyên thay hình đổi dạng vì gió thổi nhưng vẫn mãi mãi là biển cát mà ông đã biết từ thuở nhỏ. Tuy vậy, tự đáy lòng mình, ông không thể không cảm thấy vui trước hạnh phúc của mỗi người lữ khách, sau bao ngày chỉ có cát vàng với trời xanh nay được thấy chà là xanh tươi hiện ra trước mắt. ‘Có thể Thượng đế tạo ra sa mạc chỉ để cho con người biết quý trọng cây chà là,’ ông nghĩ.”', 'uploads/1762326042_nhasachmienphi-nha-gia-kim.jpg'),
(3, 'Hạt giống tâm hồn ', 'Nhiều tác giả', 'novel ', 1993, 3, 'https://ebookvie.com/ebook/hat-giong-tam-hon-tron-bo-11-cuon/', 'Hạt Giống Tâm Hồn là một tuyển tập gồm nhiều câu chuyện ngắn được viết bởi tác giả Jack Canfield, Mark Victor Hansen và Barbara De Angelis. Tác phẩm này đã được phát hành lần đầu vào năm 1993 và đã trở thành một trong những cuốn sách bán chạy nhất trên thị trường. Hạt Giống Tâm Hồn đã có sức ảnh hưởng lớn đối với hàng triệu độc giả trên khắp thế giới, và đã trở thành nguồn cảm hứng vô tận cho những người đang tìm kiếm ý nghĩa và sự động viên trong cuộc sống.', 'uploads/ebook-hat-giong-tam-hon-full-prc-pdf-epub-azw3.jpg'),
(4, 'Đắc Nhân Tâm ', 'Dale Carnegie', 'novel', 1936, 3, 'https://nhasachmienphi.com/dac-nhan-tam.html', 'Khi ta nhắc đến cuốn sách “Đắc Nhân Tâm” của Dale Carnegie, không chỉ đơn thuần là một tác phẩm nổi tiếng mà còn là một kim chỉ nam giúp con người giao tiếp hiệu quả hơn. Sách không chỉ mang lại kiến thức về nghệ thuật kết nối mà còn mở ra những cánh cửa tư duy mới mẻ về mối quan hệ giữa con người trong xã hội hiện đại. Cuốn sách đã chuyền cảm hứng cho hàng triệu người trên khắp thế giới, với hơn 15 triệu bản được bán ra . Đây không chỉ là một con số ấn tượng, mà còn phản ánh sức hút mạnh mẽ cũng như tầm ảnh hưởng lớn lao của nó đến cách sống và cách ứng xử của từng cá nhân.\r\n\r\nCâu chuyện trong chương đầu tiên của cuốn sách mô tả một hoàn cảnh khá thú vị: Abraham Lincoln dự tính gửi thư cho một người ông không ưa, nhưng cuối cùng đã quyết định không gửi. Qua điều này, Carnegie muốn truyền đạt rằng đôi khi suy nghĩ thấu đáo và hiểu biết tâm lý của người khác là cách để gặt hái thành công trong giao tiếp . Bilateral understanding (hiểu biết lẫn nhau) không chỉ làm cho tình thế trở nên dễ chịu hơn mà còn tạo lập niềm tin giữa các mối quan hệ.', 'uploads/dac-nhan-tam.webp'),
(5, 'Cách nghĩ để thành công ', 'Napoleon Hill', 'novel', 1937, 5, 'https://dilib.vn/tom-tat-sach/cach-nghi-de-thanh-cong-401.html', 'Cuốn sách \"Cách Nghĩ Để Thành Công\" (tựa gốc: Think and Grow Rich) của Napoleon Hill là một tác phẩm kinh điển về phát triển bản thân và làm giàu, được xuất bản lần đầu vào năm 1937. Sau hơn 20 năm nghiên cứu và phỏng vấn hơn 500 người thành công nhất thời bấy giờ (bao gồm Andrew Carnegie, Henry Ford, Thomas Edison, F.W. Woolworth, và Alexander Graham Bell), Napoleon Hill đã đúc kết được 13 nguyên tắc mà ông cho là bí quyết chung dẫn đến sự giàu có và thành công vượt bậc. Sách không chỉ nói về tiền bạc mà còn là một triết lý toàn diện về cách làm chủ tư duy để kiến tạo mọi điều bạn mong muốn trong cuộc sống.', 'uploads/401-cach-nghi-de-thanh-cong-1.jpg'),
(6, 'Đời thay đổi khi chúng ta thay đổi', 'ANDREW MATTHEWS', 'novel', 1988, 4, 'https://docsach24.co/e-book/doi-thay-doi-khi-chung-ta-thay-doi-3691.html', 'hsak', 'uploads/doi_thay_doi_khi_chung_ta_thay_doi.jpg'),
(8, 'Đọc Vị Bất Kỳ Ai ', 'David J. Lieberman', 'Life Skills', 2018, 3, 'https://file.nhasachmienphi.com/pdf/nhasachmienphi-doc-vi-bat-ky-ai-de-khong-bi-lua-doi-va-loi-dung.pdf', 'Tác phẩm \"Đọc vị bất kỳ ai\" là cẩm nang dạy bạn cách thâm nhập vào tâm trí của người\r\nkhác để biết điều người ta đang nghĩ. Cuốn sách này se không giúp bạn rút ra các kết luận\r\nchung về một ai đó dựa vào cảm tính hay sự võ đoán. Những nguyên tắc được chia sẻ\r\ntrong cuốn sách này không đơn thuần là những lý thuyết hay mẹo vặt chỉ đúng trong một\r\nsố trường hợp hoặc với những đối tượng nhất định. Các kết quả nghiên cứu trong cuốn sách\r\nnày được đưa ra dựa trên phương pháp S.N.A.P - cách thức phân tích và tìm hiểu tính cách\r\nmột cách bài bản trong phạm vi cho phép mà không làm mếch lòng đối tượng được phân\r\ntích. Phương pháp này dựa trên những phân tích về tâm lý, chứ không chỉ đơn thuần dựa\r\ntrên ngôn ngữ cử chỉ, trực giác hay võ đoán.', 'uploads/Đọc-vị-bất-kỳ-ai-2-1-1024x682.jpg'),
(9, 'Tiếng gọi nơi hoang dã ', 'Jack London', 'Adventure story', 1903, 3, 'https://ia802308.us.archive.org/15/items/sachvui.-com-tieng-goi-noi-hoang-da-jack-london/Sachvui.Com-tieng-goi-noi-hoang-da-jack-london.pdf', 'Đến với tiếng gọi nơi hoang dã, Jack London mới thể hiện tất cả sức mạnh của ngòi bút và tư tưởng của mình. Ngược với Nanh trắng, chú chó Buck đã từ thế giới văn minh tìm ngược về nơi hoang dã, đi theo tiếng gọi tự do chân chính của giống nòi. Tuy nhiên, thẳm sâu trong Buck vẫn vương vấn tình cảm với con người duy nhất mà nó yêu thương yêu. Buck tồn tại độc lập với tính cách độc đáo, như một nhân vật không thể bị che lấp.\r\n\r\nTình yêu nhiệt thành với cuộc sống đã tạo nên những trang viết đầy sức cuốn hút của Jack London và khiến các tác phẩm của ông được yêu mến trên toàn thế giới.', 'uploads/nhasachmienphi-tieng-goi-noi-hoang-da.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'na', '202cb962ac59075b964b07152d234b70'),
(2, 'admin', '289dff07669d7a23de0ef88d2f7129e7');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
