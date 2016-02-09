package com.pcmesh.controllers;

import java.security.Principal;
import java.text.DateFormat;
import java.util.Date;
import java.util.List;
import java.util.Locale;

import javax.servlet.http.HttpServletResponse;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;

import com.pcmesh.domain.ConnectorNode;

/**
 * Handles requests for the application home page.
 */
@Controller
public class HomeController {
	
	List<ConnectorNode> connectorList;
	int count = 0;
	
	private static final Logger logger = LoggerFactory.getLogger(HomeController.class);
	
	/**
	 * Simply selects the home view to render by returning its name.
	 */
	@RequestMapping(value = "/", method = RequestMethod.GET)
	public String home(Locale locale, Model model) {
		logger.info("Welcome home! The client locale is {}.", locale);
		
		Date date = new Date();
		DateFormat dateFormat = DateFormat.getDateTimeInstance(DateFormat.LONG, DateFormat.LONG, locale);
		
		String formattedDate = dateFormat.format(date);
		
		model.addAttribute("serverTime", formattedDate );
		
		return "home";
	}
	
	@RequestMapping(value = "/", method = RequestMethod.POST)
	public String home(
			@RequestParam(value = "xposition", required = true) int xPosition, 
			@RequestParam(value = "yposition", required = true) int yPosition, 
			@RequestParam(value = "pid", required = true) int pid,
			@RequestParam(value = "checkbox", required = true) int checkbox,
			@RequestParam(value = "neighborID", required = true) int[] neighborID,
			ModelMap model) {	
		
			ConnectorNode node = new ConnectorNode(count);
			count++;
			node.setXPosition(xPosition);
			node.setYPosition(yPosition);
			node.setPID(pid);
			node.setConnectorCheck(checkbox);
			node.setNeighborIDS(neighborID);
			connectorList.add(node);
			
			logger.info("hello");

			return "home";

	}
	
}
