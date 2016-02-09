package com.pcmesh.domain;

import java.awt.Color;
import java.awt.Frame;
import java.awt.Graphics;
import java.awt.Graphics2D;

public class ConnectorNode extends Frame {

	private int id;
	private int connectorCheck;
	private int yPosition;
	private int xPosition;
	private int[] neighborIDS;
	private String message;
	private int pID; 
	
	public ConnectorNode(int i) {
		id = i;
	}
	
	public void paint(Graphics g)  {
		Graphics2D circle = (Graphics2D) g;
		circle.setPaint(Color.blue);
		circle.drawOval(150, 150, 100, 100);
		circle.fillOval(150, 150, 100, 100);
		
	}
	
	public int getXPosition()  {
		return xPosition;
	}
	
	public void setXPosition(int xPosition)  {
		this.xPosition = xPosition;
	}
	
	public int getYPosition()  {
		return yPosition;
	}
	
	public void setYPosition(int yPosition)  {
		this.yPosition = yPosition;
	}
	
	public int getpID()  {
		return pID;
	}
	
	public void setPID(int p)  {
		this.pID = p;
	}
	
	public int getConnectorCheck()  {
		return connectorCheck;
	}
	
	public void setConnectorCheck(int check)  {
		this.connectorCheck = check;
	}
	
	public int[] getNeighborIDS()  {
		return neighborIDS;
	}
	
	public void setNeighborIDS(int[] ids)  {
		this.neighborIDS = ids;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getMessage() {
		return message;
	}

	public void setMessage(String message) {
		this.message = message;
	}
}
